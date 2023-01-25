from django.db import models
# Create your models here.
class Post(models.Model):
    #Pas de titre
    #title = models.CharField(max_length=70, blank=False, default='')
    #twitte :
    content = models.CharField(max_length=255,blank=False, default='')
    userId = models.IntegerField(blank=True, null=True) 
    publishDate = models.DateTimeField(auto_now_add=True)
    pathMedia = models.ImageField(upload_to='images/')
    published = models.BooleanField(default=True)
    
    def __str__(self):
        return self.content 
    #media
    #document = models.FileField(upload_to='document/')
    #uploaded_at = models.DateTimeField(auto_now_add=True)