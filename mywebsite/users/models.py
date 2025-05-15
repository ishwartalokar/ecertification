from django.db import models
from django.contrib.auth.hashers import make_password, check_password

class Institute(models.Model):
    id = models.AutoField(primary_key=True)
    institute_name = models.CharField(max_length=100)
    address = models.CharField(max_length=255)
    city = models.CharField(max_length=200)
    country = models.CharField(max_length=150)

    def __str__(self):
        return f"{self.institute_name}"

    class Meta:
        db_table = 'institute'


class Admin(models.Model):
    id = models.AutoField(primary_key=True)
    username = models.CharField(max_length=100)
    password = models.CharField(max_length=100)
    institute_id = models.ForeignKey(Institute,on_delete = models.CASCADE,related_name='institute')
    #institute_id = models.PositiveIntegerField()
    updation_date = models.DateTimeField(auto_now=True)

    class Meta:
        db_table = 'admin'

    def set_password(self, raw_password):
        """Hashes the password and stores it."""
        self.password = make_password(raw_password)

    def check_password(self, raw_password):
        """Compares the given password with the stored hashed password."""
        return check_password(raw_password, self.password)

    def __str__(self):
        return self.username

class Department(models.Model):
    id = models.AutoField(primary_key=True)
    department_name = models.CharField(max_length=150, null=True, blank=True)
    department_short_name = models.CharField(max_length=100)
    department_code = models.CharField(max_length=50, null=True, blank=True)
    creation_date = models.DateTimeField(auto_now_add=True)

    def __str__(self):
        return self.department_name

    class Meta:
        db_table = 'tbldepartments'

class CertificateType(models.Model):
    id = models.AutoField(primary_key=True)
    certificate_type = models.CharField(max_length=200, null=True, blank=True)
    description = models.TextField(null=True, blank=True)
    creation_date = models.DateTimeField(auto_now_add=True)

    def __str__(self):
        return f"Certificate: {self.certificate_type}"

    class Meta:
        db_table = 'tcertificatetype'

class User(models.Model):
    username = models.CharField(max_length=150, unique=True)
    password = models.CharField(max_length=255)

    def set_password(self, raw_password):
        """Hashes the password and stores it."""
        self.password = make_password(raw_password)

    def check_password(self, raw_password):
        """Compares the given password with the stored hashed password."""
        return check_password(raw_password, self.password)

    def __str__(self):
        return self.username

class UserProfile(models.Model):
    user = models.OneToOneField(User, on_delete=models.CASCADE, related_name="profile")
    id = models.AutoField(primary_key=True)
    sid = models.CharField(max_length=100, unique=True)
    first_name = models.CharField(max_length=150)
    father_name = models.CharField(max_length=150)
    last_name = models.CharField(max_length=150, null=True, blank=True)
    email_id = models.EmailField(max_length=200, unique=True)
    gender = models.CharField(max_length=100)
    dob = models.CharField(max_length=100)
    department = models.CharField(max_length=255)
    pursuing_class = models.CharField(max_length=30)
    address = models.CharField(max_length=255)
    city = models.CharField(max_length=200)
    country = models.CharField(max_length=150)
    phone_number = models.CharField(max_length=11)
    status = models.BooleanField(default=False)
    image = models.CharField(max_length=100, null=True, blank=True)
    reg_date = models.DateTimeField(auto_now_add=True)
    nss = models.BooleanField(null=True)
    age = models.PositiveIntegerField(null=True)
    institute_id = models.PositiveIntegerField(null=True)

    def __str__(self):
        return self.first_name

    class Meta:
        db_table = 'tstudent'

from django.db import models
from .models import UserProfile

class Contact(models.Model):
    name = models.CharField(max_length=100)
    email = models.EmailField()
    subject = models.CharField(max_length=200)
    message = models.TextField()
    created_at = models.DateTimeField(auto_now_add=True)

    def __str__(self):
        return self.name


class Certificate(models.Model):
    STATUS_CHOICES = [
        (0, 'Waiting'),
        (1, 'Approved'),
        (2, 'NotApproved'),

    ]

    READ_CHOICES = [
        (0, 'Unread'),
        (1, 'Read'),
    ]

    id = models.AutoField(primary_key=True)
    certificate_type = models.CharField(max_length=110)  # Example: "Degree", "Participation"
    description = models.TextField()  # Description or purpose of the certificate
    posting_date = models.DateTimeField(auto_now_add=True)  # Date the certificate was issued
    admin_remark = models.TextField(null=True, blank=True)  # Remarks from the admin
    status = models.IntegerField(choices=STATUS_CHOICES, default=1)  # Active or Inactive
    is_read = models.IntegerField(choices=READ_CHOICES, default=0)  # Unread or Read status
    user_profile = models.ForeignKey(
        UserProfile, on_delete=models.CASCADE, related_name="certificates"
    )  # Link to the user profile
    admin_action_taken_date = models.DateTimeField(auto_now=True)

    

    class Meta:
        db_table = 'tcertificate'

    def __str__(self):
        return f"{self.certificate_type} for {self.user_profile.id}"