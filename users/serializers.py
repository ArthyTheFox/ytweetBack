from rest_framework import serializers 
from logins.models import Login
 
 
class CreateUserSerializer(serializers.ModelSerializer):
 
    class Meta:
        model = Login
        fields = ('pseudo',
                    'lastname',
                    'firstname',
                    'email',
                    'password',
                    )