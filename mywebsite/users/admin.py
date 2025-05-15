from django.contrib import admin
from .models import User,Institute,Department,UserProfile

@admin.register(User)
class UserAdmin(admin.ModelAdmin):
    list_display = ('username',)
admin.site.register(Institute)
admin.site.register(Department)
admin.site.register(UserProfile)

