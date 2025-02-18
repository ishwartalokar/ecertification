from django.shortcuts import render, redirect
from django.contrib import messages
from django.contrib.auth.hashers import check_password
from .models import User,Contact,Certificate
from django.contrib.auth.decorators import login_required

from .forms import LoginForm,ContactForm


from .models import User, UserProfile

def user_list_view(request):
    # Fetch all users from the User model (users_user table)
    users = User.objects.all()
    return render(request, 'users/userview.html', {'users': users})

def sample_view(request):
    return render(request,"users/sample.html")

def index_web_view(request):
    context = {
        'contact_no': "(+91) 774 389 4219",
        'email_address':"support@ecert.in",
        'city_address':"Pune"
    }
    return render(request,"users/index.html",context)



def contact_web_view(request):
    context = {
        'contact_no': "(+91) 774 389 4219",
        'email_address':"support@ecert.in",
        'city_address':"Pune"
    }
    form_submitted = False  # Flag to indicate if the form was submitted

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

    return render(request, 'users/contact.html', {'form_submitted': form_submitted})


def thank_you(request):
    return render(request,"users/thank_you.html")


def about_web_view(request):
    return render(request,"users/about.html")

def register_web_view(request):
    return render(request,"users/register.html")


def admin_login_web_view(request):
    return render(request,"owner/login.html")


def contact_us(request):
    form_submitted = False  # Flag to indicate if the form was submitted

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

    return render(request, 'users/contactus.html', {'form_submitted': form_submitted})




def login_view(request):
    if request.method == 'POST':
        username = request.POST['username']
        password = request.POST['password']

        try:
            user = User.objects.get(username=username)
            if check_password(password, user.password):
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
    request.session.flush()  # Clear all sessions
    return redirect('login')

from django.shortcuts import render, redirect
from .models import User, UserProfile, Certificate
from django.contrib import messages

def certificate_view(request):
    # Get the user_id from the session
    user_id = request.session.get('user_id')

    # Check if user_id exists in session, otherwise redirect to login page
    if not user_id:
        messages.error(request, "Please log in to view your certificates.")
        return redirect('login')

    try:
        # Fetch the user and user profile using the user_id from session
        user = User.objects.get(id=user_id)
        user_profile = UserProfile.objects.get(user=user)

        # Fetch all certificates associated with this user's profile
        certificates = Certificate.objects.filter(user_profile=user_profile)

    except User.DoesNotExist:
        messages.error(request, "User does not exist.")
        return redirect('login')
    except UserProfile.DoesNotExist:
        messages.error(request, "User profile not found.")
        return redirect('login')

    # Prepare context data for rendering the template
    context = {
        'user': user,
        'profile': user_profile,
        'certificates': certificates,
    }

    return render(request, 'users/chistory.html', context)


'''
from django.shortcuts import render, get_object_or_404
from django.http import HttpResponse
from weasyprint import HTML
from .models import Certificate
from django.template.loader import render_to_string

def certificate_pdf(request, certificate_id):
    # Fetch the certificate by its ID
    certificate = get_object_or_404(Certificate, id=certificate_id)

    # Prepare the context data for rendering the certificate
    context = {
        'certificate': certificate,
    }

    # Render the certificate template into a string
    html_string = render_to_string('users/pdftemplate.html', context)
    
    # Generate the PDF from the HTML string
    html = HTML(string=html_string)
    pdf = html.write_pdf()

    # Return the PDF as a response
    response = HttpResponse(pdf, content_type='application/pdf')
    response['Content-Disposition'] = f'attachment; filename=certificate_{certificate_id}.pdf'

    return response
'''
from django.shortcuts import render, redirect
from django.contrib import messages
from .forms import CertificateApplicationForm
from .models import Certificate, UserProfile

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

def change_password_view(request):
    return render(request,"users/setloginpass.html")

def privacy_view(request):
    return render(request,"users/privacy.html")

def tandc_view(request):
    return render(request,"users/tandc.html")

def license_view(request):
    return render(request,"users/license.html")


from django.shortcuts import render, redirect
from .forms import UpdateProfileForm
from .models import UserProfile

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
