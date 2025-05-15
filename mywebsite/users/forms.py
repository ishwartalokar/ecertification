from django import forms
from .models import Contact,Certificate,Department


class TestForm(forms.Form):
    num1 = forms.IntegerField(label="1st No.")
    num2 = forms.IntegerField()



class LoginForm(forms.Form):
    username = forms.CharField(max_length=150)
    password = forms.CharField(widget=forms.PasswordInput)

class ContactForm(forms.ModelForm):
    class Meta:
        model = Contact
        fields = ['name', 'email', 'subject', 'message']  # Ensure these match your model fields
        widgets = {
            'name': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Your Name'}),
            'email': forms.EmailInput(attrs={'class': 'form-control', 'placeholder': 'Your Email'}),
            'subject': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Subject'}),
            'message': forms.Textarea(attrs={'class': 'form-control', 'placeholder': 'Your Message'}),
        }

from django import forms
from .models import CertificateType

class CertificateApplicationForm(forms.Form):
    certificate_type = forms.ModelChoiceField(
        queryset=CertificateType.objects.all(),
        empty_label="Select Certificate Type...",
        widget=forms.Select(attrs={
            'class': 'form-control',
        }),
        label="Certificate Type"
    )
    description = forms.CharField(
        widget=forms.Textarea(attrs={
            'class': 'form-control',
            'placeholder': 'Enter purpose or details...',
            'rows': 4,
            'maxlength': 500
        }),
        label="Purpose of Certificate",
        required=True
    )

from django import forms
from .models import UserProfile

class UpdateProfileForm(forms.ModelForm):
    class Meta:
        model = UserProfile
        fields = ['first_name', 'last_name', 'email_id', 'phone_number']
        widgets = {
            'first_name': forms.TextInput(attrs={'class': 'form-Control'}),
            'last_name': forms.TextInput(attrs={'class': 'form-Control'}),
            'email_id': forms.EmailInput(attrs={'class': 'form-Control'}),
            'phone_number': forms.TextInput(attrs={'class': 'form-Control'}),
        }


class DepartmentForm(forms.ModelForm):
    class Meta:
        model = Department
        fields = ['department_name', 'department_short_name', 'department_code']
        widgets = {
            'department_name': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Department Name', 'required': True}),
            'department_short_name': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Department Short Name', 'required': True}),
            'department_code': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Department Code', 'required': True}),
        }

class CertificateTypeForm(forms.ModelForm):
    class Meta:
        model = CertificateType
        fields = ['certificate_type', 'description']
        widgets = {
            'certificate_type': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Certificate Name', 'required': True}),
            'description': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Description of certificate', 'required': True}),
        }

class DepartmentForm(forms.ModelForm):
    class Meta:
        model = Department
        fields = ['department_name', 'department_short_name', 'department_code']
        widgets = {
            'department_name': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Department Name', 'required': True}),
            'department_short_name': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Department Short Name', 'required': True}),
            'department_code': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Department Code', 'required': True}),
        }


from django import forms
from .models import UserProfile,Institute,User
from django.core.exceptions import ValidationError
from django.forms.widgets import DateInput

class StudentForm(forms.ModelForm):
    password = forms.CharField(widget=forms.PasswordInput)
    confirmpassword = forms.CharField(widget=forms.PasswordInput)

    institute_name = forms.ModelChoiceField(
        queryset=Institute.objects.all(),
        empty_label="Select Institute Name ...",
        widget=forms.Select(attrs={
            'class': 'form-control',
        }),
        label="Institute Name"
    )
    
    
    class Meta:
        model = UserProfile
        fields = [
            'sid', 'first_name','father_name','last_name', 'gender', 'dob',
            'department', 'pursuing_class', 'address', 'city', 'country',
            'phone_number', 'email_id', 'password'
        ]
    widgets = {
        'dob': DateInput(attrs={'type': 'date', 'placeholder': 'DD-MM-YYYY'}),
        'password': forms.PasswordInput(),
    }


    widgets = {
            'dob': DateInput(attrs={'type': 'date', 'placeholder': 'DD-MM-YYYY'}),
            'password': forms.PasswordInput(),
        }

    def clean(self):
        cleaned_data = super().clean()
        password = cleaned_data.get("password")
        confirm_password = cleaned_data.get("confirmpassword")

        if password != confirm_password:
            raise ValidationError("Password and Confirm Password do not match.")

from django import forms
from .models import Certificate,Institute

class AdminTakeActionForm(forms.ModelForm):
    class Meta:
        model = Certificate
        fields = ['status', 'admin_remark']
        widgets = {
            'status': forms.Select(attrs={
                'class': 'browser-default',
                'required': True,
            }),
            'admin_remark': forms.Textarea(attrs={
                'id': 'textarea1',
                'class': 'materialize-textarea',
                'placeholder': 'Description',
                'maxlength': '500',
                'required': True,
            }),
        }


class InstituteForm(forms.ModelForm):
    class Meta:
        model = Institute
        fields = ['institute_name', 'address', 'city','country']
        widgets = {
            'institute_name': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Institute Name', 'required': True}),
            'address': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Address', 'required': True}),
            'city': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'City', 'required': True}),
            'country': forms.TextInput(attrs={'class': 'form-control', 'placeholder': 'Coutry', 'required': True}),
        }
