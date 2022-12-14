from rest_framework import serializers 
from logins.models import Login
 
 
class loginSerializer(serializers.ModelSerializer):
 
    class Meta:
        model = Login
        fields = ('email',
                    'password')