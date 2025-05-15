from django.contrib import admin
from django.urls import path
from users import views

urlpatterns = [
    path('admin/', admin.site.urls),
    path('login/', views.login_view, name='login'),
    path('dashboard/', views.dashboard, name='dashboard'),
    path('logout/', views.logout_view, name='logout'),
    path('', views.index_web_view, name='home'),
    path('home/', views.index_web_view, name='home'),
    path('contact/', views.contact_web_view, name='contact'),
    path('about/', views.about_web_view, name='about'),
    path('register/', views.register_web_view, name='register'),
    path('thank_you/', views.thank_you, name='thank_you'),
    path('certificates/', views.certificate_view, name='certificates'),
    path('apply/', views.apply_certificate, name='apply_certificate'),
    path('profile/', views.profile_changes, name='profile'),
    path('password/', views.change_password_view, name='change_password'),
    path('privacy/', views.privacy_view, name='privacy'),
    path('license/', views.license_view, name='license'),    
    path('term&conditions/', views.tandc_view, name='tandc'),
    path('update-profile/', views.update_profile, name='update_profile'),
    path('admin_dashboard/', views.admin_dashboard_view, name='admindashboard'),
    path('adminlogin/', views.admin_login_view, name='adminlogin'),
    path('department/', views.add_department_view, name='department'),
    path('mdepartment/', views.manage_department_view, name='mdepartment'),
    path('addctype/', views.add_certificate_type, name='addctype'),
    path('mcertificatetype/', views.manage_certificate_type, name='mcertificatetype'),
    path('addstudent/', views.add_student_view, name='addstudent'),
    path('pending_certificates_history/', views.pending_certificate_history, name='pchistory'),
    path('cpass/', views.change_admin_password, name='cpass'),
    path('notifications/', views.notifications_view, name='notifications'),
    path('edepartment/<int:deptid>', views.edit_department, name='edepartment'),
    path('ecertificatetype/<int:ctypeid>', views.edit_certificatetype, name='ecertificatetype'),
    path('mstudent/', views.manage_students, name='mstudent'),
    path('activate-student/<int:student_id>/', views.activate_student, name='activate_student'),
    path('deactivate-student/<int:student_id>/', views.deactivate_student, name='deactivate_student'),
    path('takeaction/<int:cert_id>/', views.take_action_on_certificate_view, name='takeaction'),
    path('applied_certificate_history/', views.uspecific_certificate_history, name='uchistory'),
    path('generate_certificate/<int:cert_id>/', views.generate_pdf, name='generate_certificate'),
    path('institute/', views.add_institute_view, name='institute'),
    path('einstitute/<int:instid>', views.edit_institute, name='einstitute'),
    path('minstitute/', views.manage_institute_view, name='minstitute'),
    path('analysis/', views.bargraph, name='analysis'),
    path('test/', views.testing, name='test')


]


from django.conf.urls import handler404
from django.shortcuts import render

def page_not_found(request, exception):
    return render(request, 'owner/404.html', status=404)

handler404 = page_not_found
