
{% extends 'base.html' %}
{% load i18n %}
{% load static %}

{% block title %}
Prédications
{% endblock title %}






{% block content %}

<header class="page-title pt-small" style="margin-top: 70px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">{% trans 'Prédications' %}</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="/{{ lang }}">{% trans 'Accueil' %}</a></li>
          <li class="active">{% trans 'Prédications' %}</li>
        </ol>
      </div>
    </div>
  </header>




<div class="gray-bg">
    <section class="container section team-3col">
      <div class="row">
        
        <header class="sec-heading">
          <h2>{% trans 'Prédications vidéos' %}</h2>
          <span class="subheading">{% trans 'Des vidéos du Prophète KACOU Philippe' %}</span>
        </header>

        <!-- Member 1 -->

        {% for videos in videos %} 

        
        <div class="col-lg-6 col-md-6 mb-sm-50 " style="padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom: 10px">
          <div class="t-item" style="width: 100%" > 

            <!-- Image -->
            
                <iframe width="100%" height="300px" src="https://www.youtube.com/embed/{{ videos.url }}?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
             
            

            <!-- Info -->
            

          </div><!-- / .t-item -->
        </div>
        {% endfor %} 
        
        <!-- / .col-md-4 -->


       


      </div><!-- / .row -->
    </section><!-- / .contianer -->
  </div>
{% endblock content %} 





