from django.db import models

# Create your models here.
class Post(models.Model):
    #Pas de titre
    #title = models.CharField(max_length=70, blank=False, default='')
    #twitte :
    content = models.CharField(max_length=200,blank=False, default='')
    userId = models.IntegerField(blank=True, null=True) 
    publishDate = models.DateTimeField(auto_now=True)
    pathMedia = models.CharField(max_length=200,blank=False, default='')
    published = models.BooleanField(default=True)
    #media
    #document = models.FileField(upload_to='document/')
    #uploaded_at = models.DateTimeField(auto_now_add=True)