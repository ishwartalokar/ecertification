from django import forms
from .models import Contact,Certificate


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

