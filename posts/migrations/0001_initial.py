# Generated by Django 4.1.3 on 2022-11-30 11:16

from django.db import migrations, models


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='Posts',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('content', models.CharField(default='', max_length=200)),
                ('userId', models.IntegerField(blank=True, null=True)),
                ('publishDate', models.DateTimeField(auto_now=True)),
                ('pathMedia', models.CharField(default='', max_length=200)),
            ],
        ),
    ]
