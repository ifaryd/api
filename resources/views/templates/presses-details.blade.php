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
        <h1 class="col-sm-6">Prédications</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="accueil">Accueil</a></li>
          <li><a href="presses-lists">Presses</a></li>
                  <li class="active">CONDAMNÉ À 5 ANNÉES DE RECLUSION</li>
        </ol>
      </div>
    </div>
  </header>




  
  <div id="blog" class="section container blog-classic">
    <div class="row">
      <div class="col-md-12 mb-sm-160">
        
          <!-- Blog Post -->
          <div class="col-md-12 blog-post-single wow fadeIn" data-wow-delay=".1s" data-wow-duration="2s">

            <!-- Image -->
            <img class="img-responsive post-img" src="{% static 'images/philippe.jpeg' %}" alt="Blog Po" style="max-width: 400px;">

            <!-- Meta data -->
            <div class="post-meta">
              <a href="#" class="post-date">
                <i class="fa fa-calendar-o"></i>
                <span>12 Septembre 2020</span>
              </a>
            
            </div><!-- / .meta -->

            <!-- Title -->
            <h2 class="post-title">Condamné à 5 années de reclusion </h2>
            

            <div class="blog-post-content">
              <!-- Intro -->
              <blockquote>
                Condamné à cinq années de réclusion, pour radicalisme religieux, le prophète Kacou Philippe s’est retiré dans son village natal, à Katadji. Ce, après avoir bénéficié de la grâce présidentielle.
              </blockquote>

            </div>
            
          </div><!-- / .blog-post-single -->
          
          

          <!-- ========== Comments ========== -->

         
       
      </div><!-- / .col-md-8 -->



      <!-- ========== Sidebar ========== -->

    

    </div><!-- / .row -->
  </div><!-- / .container -->

{% endblock content %} 