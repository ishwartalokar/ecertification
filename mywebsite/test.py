from django.utils import timezone
from users.models import User, UserProfile

# Create a User object
user = User.objects.create(username="ishwar")
user.set_password("12345")
user.save()

# Create a related UserProfile object
user_profile = UserProfile.objects.create(
    user=user,
    sid="S123456",
    first_name="John",
    last_name="Doe",
    email_id="john.doe@example.com",
    gender="Male",
    dob="1990-05-15",
    department="Computer Science",
    pursuing_class="TYBSc",
    address="123 Elm Street",
    city="Springfield",
    country="USA",
    phone_number="1234567890",
    status=True,
    image="profile_images/john_doe.jpg",
    reg_date=timezone.now(),
    nss=1,
    age=34,
    contact_no="123-456-7890"
)

print("UserProfile created:", user_profile)



from django.utils import timezone
from users.models import Admin

# Create a User object
admin = Admin.objects.create(username="admin")
admin.set_password("12345")
admin.save()