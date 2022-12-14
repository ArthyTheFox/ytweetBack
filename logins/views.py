from django.shortcuts import render

from django.http.response import JsonResponse
from rest_framework import status

from rest_framework.decorators import api_view
from logins.serializers import loginSerializer
from django.contrib.auth import authenticate


@api_view(['GET', 'POST', 'DELETE'])
def login(request):
    if request.method == 'POST':
        login_serializer = loginSerializer(data=request.data)
        user=None
        if login_serializer.is_valid():
            user = authenticate(username=login_serializer.data['email'], password=login_serializer.data['password'])
            if user is not None:
                login_serializer.save()
                return JsonResponse(login_serializer.data, status=status.HTTP_201_CREATED)
            else:
                return JsonResponse(login_serializer.errors, status=status.HTTP_400_BAD_REQUEST)
        return JsonResponse(login_serializer.errors, status=status.HTTP_400_BAD_REQUEST)    