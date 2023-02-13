{% extends 'base.html' %}
{% load i18n %}

{% block title %}
Galeries
{% endblock title %}





{% block content %}

<header class="page-title pt-small" style="margin-top: 70px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">{% trans 'Galeries' %}</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="/{{ lang }}">{% trans 'Accueil' %}</a></li>
          <li class="active">{% trans 'Galeries' %}</li>
        </ol>
      </div>
    </div>
  </header>

  <section class="container portfolio-layout portfolio-columns-boxed">
    <div class="row">
      <header class="sec-heading">
        <h2>{% trans 'Galeries Photos' %}</h2>
        <span class="subheading">{% trans 'Quelques images du message' %}</span>
      </header>
    </div><!-- / .row -->

    <div class="row ws-m wow fadeIn" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: fadeIn;">

        {% for photos in photos %} 
        <!-- Item 1 -->
        <div class="col-md-4 portfolio-item print">
          <div class="p-wrapper hover-default" style="height: 292px !important;">
            <img src="{{ photos.url }}" alt="Project Example">
            <div class="p-hover" style="height: 292px !important;">
              <div class="p-content">
                
                <h6 class="subheading">{{ photos.description }}</h6>
              </div>
            </div>
            <a href="{{ photos.url }}" class="open-btn open-gallery"><i class="fa fa-expand"></i></a>
          </div>
        </div><!-- / .portfolio-item -->
        {% endfor %} 

    

    </div><!-- / .row -->
  </section>

{% endblock content %} 