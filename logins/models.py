from django.db import models

# Create your models here.
class Login(models.Model):
    #Pas de titre
    #title = models.CharField(max_length=70, blank=False, default='')
    #twitte :
    idUser = models.AutoField(null=False,auto_created=True,primary_key=True,unique=True,editable=False)
    pseudo = models.CharField(max_length=255,blank=False,default=False,unique=True)
    lastname =  models.CharField(max_length=255,blank=False,default=False)
    firstname = models.CharField(max_length=255,blank=False,default=False) 
    email = models.EmailField(max_length=255,default=False,unique=True,)
    password = models.CharField(max_length=255,blank=False,default=False)
    birthday = models.DateField(blank=False,default='1900-01-01',auto_now=False)
    idFaculty = models.IntegerField(blank=True, null=True)
    createdAT = models.DateTimeField(auto_now=True)
    updatedAT = models.DateTimeField(auto_now=True)
    pathPP = models.CharField(max_length=255,blank=False,default='')


    #published = models.BooleanField(default=False)