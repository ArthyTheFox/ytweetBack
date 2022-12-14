# Generated by Django 4.1.2 on 2022-12-14 14:21

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('logins', '0001_initial'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='login',
            name='id',
        ),
        migrations.AddField(
            model_name='login',
            name='pathPP',
            field=models.CharField(default='', max_length=255),
        ),
        migrations.AlterField(
            model_name='login',
            name='email',
            field=models.CharField(default=False, max_length=255),
        ),
        migrations.AlterField(
            model_name='login',
            name='firstname',
            field=models.CharField(default=False, max_length=255),
        ),
        migrations.AlterField(
            model_name='login',
            name='idUser',
            field=models.IntegerField(auto_created=True, blank=True, default=False, primary_key=True, serialize=False),
        ),
        migrations.AlterField(
            model_name='login',
            name='lastname',
            field=models.CharField(default=False, max_length=255),
        ),
        migrations.AlterField(
            model_name='login',
            name='password',
            field=models.CharField(default=False, max_length=255),
        ),
        migrations.AlterField(
            model_name='login',
            name='pseudo',
            field=models.CharField(default=False, max_length=255),
        ),
    ]
