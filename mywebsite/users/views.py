from django.shortcuts import render, redirect,get_object_or_404
from django.contrib import messages
from django.contrib.auth.hashers import check_password,make_password
from .models import User,UserProfile,Contact,Certificate,CertificateType,Admin,Department,Institute
from django.db.models import Count
from .forms import LoginForm,ContactForm,CertificateTypeForm,AdminTakeActionForm,UpdateProfileForm,StudentForm,InstituteForm,CertificateApplicationForm,DepartmentForm,TestForm
from django.utils import timezone
import datetime
from django.template.loader import render_to_string
from django.http import HttpResponse
import weasyprint
from django.core.mail import EmailMultiAlternatives,send_mail
from django.contrib import messages

def index_web_view(request):
    context = {
        'contact_no': "(+91) 774 389 0000",
        'email_address':"support@ecert.in",
        'city_address':"Pune"
    }
    return render(request,"users/index.html",context)


def contact_web_view(request):
    
    form_submitted = False 

    if request.method == 'POST':
        # Extract data from the POST request
        name = request.POST.get('name')
        email = request.POST.get('email')
        subject = request.POST.get('subject')
        message = request.POST.get('message')

        # Save data to the database
        Contact.objects.create(
            name=name,
            email=email,
            subject=subject,
            message=message
        )

        form_submitted = True  # Update the flag to indicate successful submission

    context = {
        'contact_no': "(+91) 774 389 4219",
        'email_address':"support@ecert.in",
        'city_address':"Pune",
        'form_submitted': form_submitted
    }
    return render(request, 'users/contact.html',context)


def thank_you(request):
    return render(request,"users/thank_you.html")

def about_web_view(request):
    return render(request,"users/about.html")

def register_web_view(request):
    return render(request,"users/register.html")


def admin_dashboard_view(request):
    admin_id = request.session.get('id')
    if not admin_id:
        messages.error(request,"Please log in first")
        return redirect('adminlogin')

    certificates = Certificate.objects.select_related('user_profile').all()
    total_certificate_types = CertificateType.objects.aggregate(Count('id'))
    total_certificate_types = total_certificate_types['id__count']

    

    total_departments = Department.objects.aggregate(Count('id'))
    total_departments = total_departments['id__count']

    total_institute = Institute.objects.aggregate(Count('id'))
    total_institute = total_institute['id__count']

    current_services = current_user_services(admin_id)

    if current_services['instid'] != 0:
        total_students = UserProfile.objects.filter(institute_id=current_services['instid']).count()
    else:
        total_students = UserProfile.objects.filter().count()


    users = UserProfile.objects.all()
    context = {
        'certificates':certificates,
        'users':users,
        'total_certificate_types':total_certificate_types,
        'total_students':total_students,
        'total_departments':total_departments,
        'total_institute':total_institute,
        'current_dashboard_for' : current_services['instid'],
        'current_admin': current_services['instname']
    }
    return render(request,"owner/dashboard.html",context)


def login_view(request):
    user_id = request.session.get('user_id')
    
    if user_id:
        return redirect('dashboard')

    if request.method == 'POST':
        username = request.POST['username']
        password = request.POST['password']

        try:
            user = User.objects.get(username=username)
            user_profile = UserProfile.objects.get(id=user.id)
            if check_password(password, user.password):
                if user_profile.status == False:
                    messages.error(request, 'Your id is inactive.please contact your admin office.')
                    return redirect('login')
                # Store session
                request.session['user_id'] = user.id
                return redirect('dashboard')
            else:
                messages.error(request, 'Invalid password.')
        except User.DoesNotExist:
            messages.error(request, 'User does not exist.')
    
    return render(request, 'users/login.html')


def dashboard(request):
    user_id = request.session.get('user_id')
    if not user_id:
        return redirect('login')

    user = User.objects.get(id=user_id)
    user_profile = UserProfile.objects.get(user=user)

    context = {
        'user': user,
        'profile': user_profile,
    }
    return render(request, 'users/dashboard.html', context)

def logout_view(request):
    admin_id = request.session.get('id')
    if admin_id:
        request.session.flush()  # Clear all sessions
        return redirect('adminlogin')

    user_id = request.session.get('user_id')
    if user_id:
        request.session.flush()  # Clear all sessions
        return redirect('login')
    if admin_id==None or user_id==None:
        return redirect('home')



def certificate_view(request):
    # Get the user_id from the session
    admin_id = request.session.get('id')

    # Check if user_id exists in session, otherwise redirect to login page
    if not admin_id:
        messages.error(request, "Please log in to view all certificates records.")
        return redirect('adminlogin')

    try:
        # Fetch all certificates associated with this user's profile
        certificates = Certificate.objects.select_related('user_profile').all()
        users = UserProfile.objects.all()

    except Admin.DoesNotExist:
        messages.error(request, "User does not exist.")
        return redirect('adminlogin')

    current_services = current_user_services(admin_id)

    # Prepare context data for rendering the template
    context = {
        'certificates': certificates,
        'user':users,
        'current_dashboard_for' : current_services['instid'],
        'current_admin': current_services['instname']
        
    }

    return render(request, 'owner/certificates.html', context)

def pending_certificate_history(request):
    # Get the user_id from the session
    admin_id = request.session.get('id')

    # Check if user_id exists in session, otherwise redirect to login page
    if not admin_id:
        messages.error(request, "Please log in to view all pending certificates request.")
        return redirect('adminlogin')

    try:
        # Fetch all certificates associated with this user's profile
        certificates = Certificate.objects.select_related('user_profile').filter(status=0)
        users = UserProfile.objects.all()

    except Admin.DoesNotExist:
        messages.error(request, "User does not exist.")
        return redirect('adminlogin')
    current_services = current_user_services(admin_id)

    # Prepare context data for rendering the template
    context = {
        'certificates': certificates,
        'user':users,
        'current_dashboard_for' : current_services['instid'],
        'current_admin': current_services['instname']
    }

    return render(request, 'owner/pchistory.html', context)



def apply_certificate(request):
    user_id = request.session.get('user_id')

    if not user_id:
        messages.warning(request, "You need to log in to apply for a certificate.")
        return redirect('login')

    try:
        user = User.objects.get(id=user_id)
        user_profile = UserProfile.objects.get(user=user)
    except UserProfile.DoesNotExist:
        messages.error(request, "User profile not found.")
        return redirect('login')

    if request.method == "POST":
        form = CertificateApplicationForm(request.POST)
        if form.is_valid():
            certificate_type = form.cleaned_data['certificate_type']
            description = form.cleaned_data['description']
            
            # Save the application to the database
            Certificate.objects.create(
                certificate_type=certificate_type.certificate_type,
                description=description,
                user_profile=user_profile,
                admin_remark="Waiting",
                status=0,
                is_read=0
            )
            print("******",user_profile.email_id)
            user_email = user_profile.email_id  # Assuming your model has an email field
            send_mail(
                subject='Form Submitted Successfully!',
                message=f'Thank you {user_profile.first_name}, your form has been submitted.',
                from_email=None,  # Will use DEFAULT_FROM_EMAIL
                recipient_list=[user_email],
                fail_silently=False,
            )
            messages.success(request, "Your certificate application was submitted successfully.")
            return redirect('apply_certificate')
    else:
        form = CertificateApplicationForm()

    return render(request, 'users/capply.html', {'form': form,'profile': user_profile})


def profile_changes(request):
    if not request.session.get('user_id'):  # Ensure the user is logged in
        return redirect('login')

    user_profile = UserProfile.objects.get(user__id=request.session['user_id'])

    if request.method == "POST":
        form = UpdateProfileForm(request.POST, instance=user_profile)
        if form.is_valid():
            form.save()
            return redirect('dashboard')  # Redirect to profile page after update
    else:
        form = UpdateProfileForm(instance=user_profile)  # Prefill form with user data
    return render(request, 'users/profile.html', {'form': form, 'profile': user_profile})



def privacy_view(request):
    return render(request,"users/privacy.html")

def tandc_view(request):
    return render(request,"users/tandc.html")

def license_view(request):
    return render(request,"users/license.html")


def update_profile(request):
    if not request.session.get('user_id'):  # Ensure the user is logged in
        return redirect('login')

    user_profile = UserProfile.objects.get(user__id=request.session['user_id'])

    if request.method == "POST":
        form = UpdateProfileForm(request.POST, instance=user_profile)
        if form.is_valid():
            form.save()
            return redirect('profile')  # Redirect to profile page after update
    else:
        form = UpdateProfileForm(instance=user_profile)  # Prefill form with user data

    return render(request, 'users/update_profile.html', {'form': form, 'user_profile': user_profile})


'''Admin Functionality'''
def admin_login_view(request):
    admin_id = request.session.get('id')
    if admin_id:
        return redirect('admindashboard')

    if request.method == 'POST':
        username = request.POST['username']
        password = request.POST['password']

        try:
            admin = Admin.objects.get(username=username)
            if check_password(password, admin.password):
                # Store session
                request.session['id'] = admin.id
                return redirect('admindashboard')
            else:
                messages.error(request, 'Invalid password.')
        except User.DoesNotExist:
            messages.error(request, 'Admin credential does not exist.')
    
    return render(request, 'owner/login.html')


def dashboard(request):
    user_id = request.session.get('user_id')
    if not user_id:
        return redirect('login')

    user = User.objects.get(id=user_id)
    user_profile = UserProfile.objects.get(user=user)

    context = {
        'user': user,
        'profile': user_profile,
    }
    return render(request, 'users/dashboard.html', context)

def add_department_view(request):
    admin_id = request.session.get('id')

    if not admin_id:
        messages.error(request, "Please log in to add the new department.")
        return redirect('adminlogin')

    if request.method == 'POST':
        form = DepartmentForm(request.POST)
        if form.is_valid():
            form.save()
            messages.success(request, "Department Added Successfully")
            return redirect('department')
        else:
            messages.error(request, "Something went wrong. Please try again.")
    else:
        form = DepartmentForm()
    return render(request, "owner/department.html", {'form': form})

def manage_department_view(request):
    # Get the user_id from the session
    admin_id = request.session.get('id')
    if not admin_id:
        messages.error(request, "Please log in to managing the list of department.")
        return redirect('adminlogin')
    try:
        # Fetch all data
        departments = Department.objects.filter()
    except Admin.DoesNotExist:
        messages.error(request, "Admin does not exist.")
        return redirect('adminlogin')
    
    if request.GET.get('del'):
        dept_id = request.GET.get('del')
        try:
            department = Department.objects.get(id=dept_id)
            department.delete()
            message = "Department record deleted"
        except Department.DoesNotExist:
            message = "Department not found"
        return render(request, 'owner/mdepartment.html', {'departments': departments, 'msg': message})

    current_services = current_user_services(admin_id)

    # Prepare context data for rendering the template
    context = {
        'departments': departments,
        'current_dashboard_for' : current_services['instid'],
        'current_admin': current_services['instname']
    }
    return render(request, 'owner/mdepartment.html', context)

def add_certificate_type(request):
    admin_id = request.session.get('id')

    if not admin_id:
        messages.error(request,"Please log in to add new  certificate type.")
        return redirect('adminlogin')
    if request.method == 'POST':
        form = CertificateTypeForm(request.POST)
        if form.is_valid():
            form.save()
            messages.success(request, "Certificate Added Successfully")
            return redirect('addctype')
        else:
            messages.error(request, "Something went wrong. Please try again.")
    else:
        form = CertificateTypeForm()
    return render(request, "owner/addctype.html", {'form': form})

def manage_certificate_type(request):
    # Get the user_id from the session
    admin_id = request.session.get('id')

    try:
        # Fetch all data
        certificates = CertificateType.objects.filter()
    except Admin.DoesNotExist:
        messages.error(request, "Admin does not exist.")
        return redirect('adminlogin')
    
    if request.GET.get('del'):
        certificate_type_id = request.GET.get('del')
        try:
            certificate = CertificateType.objects.get(id=certificate_type_id)
            certificate.delete()
            message = "certificate record deleted"
        except CertificateType.DoesNotExist:
            message = "certificate not found"
        return render(request, 'owner/mcertificatetype.html', {'certificates': certificates, 'msg': message})

    # Check if user_id exists in session, otherwise redirect to login page
    if not admin_id:
        messages.error(request, "Please log in to view or manage various certificate types.")
        return redirect('adminlogin')
    current_services = current_user_services(admin_id)
    # Prepare context data for rendering the template
    context = {
        'certificates': certificates,
        'current_dashboard_for' : current_services['instid'],
        'current_admin': current_services['instname']
    }
    return render(request, 'owner/mcertificatetype.html', context)


def certificates(request):
    return render(request,"owner/certificates.html")


def notifications_view(request):
    return render(request,"owner/notifications.html")

def change_admin_password(request):
    return render(request,"owner/cpass.html")

def edit_department(request,deptid):
    admin_id = request.session.get('id')

    if not admin_id:
        messages.error(request,"Please log in first to access this service.")
        return redirect('adminlogin')
    department = get_object_or_404(Department, id=deptid)

    if request.method == 'POST':
        form = DepartmentForm(request.POST, instance=department)
        if form.is_valid():
            form.save()
            messages.success(request, 'Department updated Successfully')
            return redirect('edepartment', deptid=department.id)
    else:
        form = DepartmentForm(instance=department)

    return render(request, "owner/edepartment.html", {'form': form, 'department': department})

def edit_certificatetype(request,ctypeid):
    certifcate_type = get_object_or_404(CertificateType, id=ctypeid)

    if request.method == 'POST':
        form = CertificateTypeForm(request.POST, instance=certifcate_type)
        if form.is_valid():
            form.save()
            messages.success(request, 'Certificate type updated Successfully')
            return redirect('ecertificatetype', ctypeid=certifcate_type.id)
    else:
        form = CertificateTypeForm(instance=certifcate_type)

    return render(request, "owner/ecertificatetype.html", {'form': form, 'department': certifcate_type})



def add_student_view(request):
    admin_id = request.session.get('id')

    if not admin_id:
        messages.error(request,"Please log in to add new student.")
        return redirect('adminlogin')
    if request.method == 'POST':
        form = StudentForm(request.POST)
        if form.is_valid():
            student = form.save(commit=False)
            institute_name = form.cleaned_data['institute_name']
            student.institute_id = institute_name.id
            print('*'*10,institute_name.id)

            # Create auth user
            user = User(username=student.email_id)
            user.set_password(form.cleaned_data['password'])
            user.save()

            # Hash student password and link to user
            student.password = make_password(form.cleaned_data['password'])
            student.user_id = user.id  # Set user_id to the created user
            student.save()

            messages.success(request, 'Student added successfully!')
            return redirect('addstudent')
    else:
        form = StudentForm()
    
    return render(request, "owner/addstudent.html", {'form': form})



def manage_students(request):
    admin_id = request.session.get('id')

    if not admin_id:
        messages.error(request,"Please log in to view or manage students.")
        return redirect('adminlogin')
    
    current_services = current_user_services(admin_id)
    current_dashboard_for = current_services['instid']
    if current_dashboard_for == 0:
        students = UserProfile.objects.all()
    else:
        students = UserProfile.objects.filter(institute_id=current_dashboard_for)
    context = {
        'students': students,
        'current_dashboard_for' : current_services['instid'],
        'current_admin': current_services['instname']
    }
    return render(request, 'owner/mstudent.html', context)

def activate_student(request, student_id):
    student = get_object_or_404(UserProfile, id=student_id)
    student.status = True
    student.save()
    messages.success(request, 'Student activated successfully.')
    return redirect('mstudent')

def deactivate_student(request, student_id):
    student = get_object_or_404(UserProfile, id=student_id)
    student.status = False
    student.save()
    messages.success(request, 'Student deactivated successfully.')
    return redirect('mstudent')

def take_action_on_certificate_view(request,cert_id):
    certificate = get_object_or_404(Certificate, id=cert_id)

    certificates = Certificate.objects.select_related('user_profile').get(id=certificate.id)
    users = UserProfile.objects.get(id=certificate.user_profile_id)
    print(certificates.status)
    
    if request.method == 'POST':
        form = AdminTakeActionForm(request.POST,instance=certificate)
        if form.is_valid():
            form.save()
            application_state = request.POST.get('status')
            data = {
            'certificates':certificates,
            'users':users,
            'form':form,
            'application_state':application_state
            }
    
            send_certificate_email(users.email_id,data)
            messages.success(request, 'Done Successfully')
            return redirect('certificates')
    else:
        form = AdminTakeActionForm()
    
    data = {
        'certificates':certificates,
        'users':users,
        'form':form
    }
    return render(request, "owner/cdetails.html",data)



def send_certificate_email(user_email, data):
    from_email = 'itcreation.techie@gmail.com'  # Use your own domain (best) or Gmail
    to = [user_email]

    # Plain text version (fallback for old email apps)
    text_content = f'Hello {data['users'].first_name}, your certificate is ready! Please check your account.'
    user_name = data['users'].first_name
    # HTML version (fancy)
    print("Application_state",data['application_state'])
    if int(data['application_state']) == 1:
        subject = 'eCertfication : Certificate Is Approved!'
        html_content = render_to_string('emails/certificate_email.html',data)
    if int(data['application_state']) == 2:
        subject = 'eCertfication : Certificate Is Rejected!'
        html_content = render_to_string('emails/certificate_email_status2.html',data)



    msg = EmailMultiAlternatives(subject, text_content, from_email, to)
    msg.attach_alternative(html_content, "text/html")
    msg.send()


def uspecific_certificate_history(request):
    # Get the user_id from the session
    user_id = request.session.get('user_id')

    # Check if user_id exists in session, otherwise redirect to login page
    if not user_id:
        messages.error(request, "Please log in to view all pending certificates request.")
        return redirect('adminlogin')

    try:
        # Fetch all certificates associated with this user's profile
        certificates = Certificate.objects.select_related('user_profile').filter(user_profile_id=user_id)
        users = UserProfile.objects.all()

    except User.DoesNotExist:
        messages.error(request, "User does not exist.")
        return redirect('login')
    
    # Prepare context data for rendering the template
    context = {
        'certificates': certificates,
        'user':users
    }

    return render(request, 'users/chistory.html', context)



def generate_pdf(request,cert_id):
    student = Certificate.objects.get(id=cert_id)
    data = UserProfile.objects.get(id=student.user_profile_id)

    current_session = request.session.get('user_id')
    print("Current_session_id",current_session)

    if current_session:
        if student.status == 1 and student.user_profile_id==current_session:
            student.is_read = 1
            student.save()

            context = {
                'data': data,
                'student':student
            }
            html_string = render_to_string('certificates/bonafide_certificate.html', context)

            response = HttpResponse(content_type='application/pdf')
            response['Content-Disposition'] = 'attachment; filename="Certificate.pdf"'

            weasyprint.HTML(string=html_string).write_pdf(response)
            return response

    if student.user_profile_id != current_session:
        return HttpResponse("Access denied or certificate not exist.")

    return HttpResponse("Your certificate yet not approved.")

def add_institute_view(request):
    admin_id = request.session.get('id')

    if not admin_id:
        messages.error(request, "Please log in to add the new institute.")
        return redirect('adminlogin')

    if request.method == 'POST':
        form = InstituteForm(request.POST)
        if form.is_valid():
            institute = form.save()
            print("u"*15,institute.id)

            admin = Admin.objects.create(username="admin"+str(institute.id),institute_id_id=institute.id)
            admin.set_password("12345")
            admin.save()
            messages.success(request, "Institute Added Successfully")
            return redirect('minstitute')
        else:
            messages.error(request, "Something went wrong. Please try again.")
    else:
        form = InstituteForm()
    current_services = current_user_services(admin_id)
    if current_services['instid'] != 0:
        return HttpResponse("Your are NOT allowed to use this service or it doesn't exists.")
    return render(request, "owner/institute.html", {'form': form})


def manage_institute_view(request):
    # Get the user_id from the session
    admin_id = request.session.get('id')
    if not admin_id:
        messages.error(request, "Please log in to managing the list of institute.")
        return redirect('adminlogin')
    try:
        # Fetch all data
        institutes = Institute.objects.filter()
    except Admin.DoesNotExist:
        messages.error(request, "Admin does not exist.")
        return redirect('adminlogin')
    
    if request.GET.get('del'):
        inst_id = request.GET.get('del')
        try:
            institute = Institute.objects.get(id=inst_id)
            institute.delete()
            message = "Institute record deleted"
        except Institute.DoesNotExist:
            message = "Institute not found"
        return render(request, 'owner/minstitute.html', {'institute': institute, 'msg': message})
    current_services = current_user_services(admin_id)

    context = {
        'institutes': institutes,
        'current_dashboard_for' : current_services['instid'],
        'current_admin': current_services['instname']
    }
    return render(request, 'owner/minstitute.html', context)

def change_password_view(request):
    return render(request,"users/setloginpass.html")

def edit_institute(request,instid):
    admin_id = request.session.get('id')

    if not admin_id:
        messages.error(request,"Please log in first to access this service.")
        return redirect('adminlogin')
    institute = get_object_or_404(Institute, id=instid)

    if request.method == 'POST':
        form = InstituteForm(request.POST, instance=institute)
        if form.is_valid():
            form.save()
            messages.success(request, 'Institute updated Successfully')
            return redirect('einstitute', instid=institute.id)
    else:
        form = InstituteForm(instance=institute)

    return render(request, "owner/einstitute.html", {'form': form, 'institute': institute})

def current_user_services(admin_id):

    admin_institute_id = Admin.objects.get(id=admin_id)
    current_dashboard_for = admin_institute_id.institute_id_id
    institute = Institute.objects.get(id=current_dashboard_for)
    current_admin = institute.institute_name

    if institute.id == 0:
        current_admin = "System Admin"

    result = {
        'instid':current_dashboard_for,
        'instname':current_admin
    }
    return result


import pandas as pd
import matplotlib.pyplot as plt
from django.shortcuts import render
import io
import urllib, base64

def bargraph(request):
    # Fetch data
    people = UserProfile.objects.all().values('age')
    df = pd.DataFrame(list(people))

    if df.empty:
        return HttpResponse("No data available to plot.")

    # Count number of people per age
    age_counts = df['age'].value_counts().sort_index()

    # Calculate percentage
    total_people = age_counts.sum()
    age_percentages = (age_counts / total_people) * 100

    # Plot Bar Graph
    plt.figure(figsize=(8, 5))
    plt.bar(age_percentages.index.astype(str), age_percentages.values, color='orange')
    plt.title('Student Age (%)')
    plt.xlabel('Age')
    plt.ylabel('Percentage (%)')
    plt.tight_layout()

    # Save to buffer
    buf = io.BytesIO()
    plt.savefig(buf, format='png')
    buf.seek(0)
    string = base64.b64encode(buf.read())
    uri = urllib.parse.quote(string)

    return render(request, 'users/bar.html', {'data': uri})

def testing(request):
    num3 = None
    students = UserProfile.objects.all()

    form = TestForm(request.POST or None)
    if form.is_valid():
        num1 = request.POST.get('num1')
        num2 = request.POST.get('num2')
        num3 = int(num1) + int(num2)


    context = {
        'students' : students,
        'result':num3,
        'form':form
    }

    return render(request,"users/test.html",context)