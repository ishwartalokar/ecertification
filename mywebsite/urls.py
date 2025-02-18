from django.contrib import admin
from django.urls import path
from users import views

urlpatterns = [
    path('admin/', admin.site.urls),
    path('login/', views.login_view, name='login'),
    path('dashboard/', views.dashboard, name='dashboard'),
    path('logout/', views.logout_view, name='logout'),
    path('sample/', views.sample_view, name='sample'),
    path('users/', views.user_list_view, name='user_list'),  # Path for user list

    path('', views.index_web_view, name='home'),
    path('home/', views.index_web_view, name='home'),
    path('contact/', views.contact_web_view, name='contact'),
    path('about/', views.about_web_view, name='about'),
    path('register/', views.register_web_view, name='register'),
    path('owner/', views.admin_login_web_view, name='adminlogin'),
    path('contactus/', views.contact_us, name='contactus'),
    path('thank_you/', views.thank_you, name='thank_you'),
    path('certificates/', views.certificate_view, name='certificates'),
    path('apply/', views.apply_certificate, name='apply_certificate'),
    path('profile/', views.profile_changes, name='profile'),
    path('password/', views.change_password_view, name='change_password'),
    path('privacy/', views.privacy_view, name='privacy'),
    path('license/', views.license_view, name='license'),    
    path('term&conditions/', views.tandc_view, name='tandc'),
    path('update-profile/', views.update_profile, name='update_profile')



 #   path('certificate/pdf/<int:certificate_id>/', views.certificate_pdf, name='certificate_pdf')


]