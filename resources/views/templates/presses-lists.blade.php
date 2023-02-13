{% extends 'base.html' %}
{% load i18n %}
{% load static %}

{% block title %}
Prédications
{% endblock title %}


{% block navbar %} 

<!-- ========== Navigation ========== -->

<nav class="navbar navbar-default navbar-trans-dark  navbar-fixed-top navbar-static-top mega">
    <div class="container" style="min-width: 93% !important;">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <!-- Logo -->
        <!-- <a class="navbar-brand log" href=""><img src="{% static 'images/logo.png" alt="Definity - Logo"></a>  -->
      </div><!-- / .navbar-header -->

      <!-- Navbar Links -->
      <div id="navbar" class="navbar-collapse collapse navr" >
        <ul class="nav navbar-nav" style="margin-top: 0px !important;">
          <li class="dropdown">
            <a href="accueil"><button class="btn-text btn-small" style="width: 176px;padding-right: 2px;padding-left: 2px;margin-top: 6px; margin-right: 35px; "> philippekacou.org</button></a>
              </li>
          
          <!-- Accueil -->
          <li class="dropdown mg">
            <a href="accueil" class="dropdown-toggle" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Accueil</a>
          <!-- / .dropdown-menu -->
          </li>
          <!-- / Accueil -->
          

          <!-- Prédications -->
          <li class="dropdown mg">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Prédications<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="predications-lists">Prédications écrites</a></li>
              <li><a href="predications-lists">Prédications audios</a></li>
              <li><a href="predications-lists">Prédications vidéos</a></li>

            </ul>
          </li>
          <!-- / Prédications -->


          <!-- Médias -->
          <li class="dropdown mg">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Médias<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="presses-lists">Presse écrites</a></li>
              <li><a href="emissions-radio">Emission radio</a></li>
              <li><a href="emissions-tv">emissions-tv</a></li>

            </ul>
          </li>
          <!-- / Médias -->


          <!-- Galerie -->
          <li class="dropdown mega-fw mg">
            <a href="galeries" class="dropdown-toggle"  data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Galérie</a>
          <!-- / .dropdown-menu -->
          </li><!-- / Galerie -->

          <!-- Ressources -->
          <li class="dropdown mg">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Ressources<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="temoignages">Témoignages</a></li>
              <li><a href="actualites-lists">Actualités</a></li>
              <li><a href="pepites">Les pépites d'or</a></li>
              <li><a href="aides">Aides pour la lectures</a></li>
              <li><a href="logiciels">Logiciels</a></li>

            </ul>
          </li>
          <!-- / Ressources -->

           <!-- Adorations -->
           <li class="dropdown mg">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Adorations<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="louanges">Louanges</a></li>
              <li><a href="melodies">Mélodies</a></li>
          

            </ul>
          </li>
          <!-- / Adorations -->

          <!-- Le monde -->
          <li class="dropdown mega-fw mg">
            <a href="mondes" class="dropdown-toggle"  data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Le cri de minuit dans monde</a>
          <!-- / .dropdown-menu -->
          </li>
          <!-- / Le monde -->

          <!-- Contacts -->
          <li class="dropdown mg">
            <a href="contacts" class="dropdown-toggle"  data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Contacts</a>
          <!-- / .dropdown-menu -->
          </li>
          <!-- / Contacts -->
        
         
        </ul>
        <!-- / .nav .navbar-nav -->
        

        <!-- Navbar Links Right -->
        <ul class="nav navbar-nav navbar-right" style="margin-top: 0px !important;">
          <li class="dropdown mg">
            <a href="" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">FR<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="">EN</a></li>
              <li><a href="">ES</a></li>
              <li><a href="">PT</a></li>
          

            </ul>
          </li>

          <!-- Languages -->
          
          <!-- / Languages -->

        </ul><!-- / .nav .navbar-nav .navbar-right -->

      </div><!--/.navbar-collapse -->
    </div><!-- / .container -->
  </nav><!-- / .navbar -->
{% endblock navbar %} 



{% block content %}

<header class="page-title pt-small" style="margin-top: 70px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">Presses</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="accueil">Accueil</a></li>
          <li class="active">Presses</li>
        </ol>
      </div>
    </div>
  </header>



  <div id="blog" class="section container blog-columns blog-masonry">
    <div class="row blog-container">

      <!-- Blog Post 1 -->
      <div class="col-md-4 blog-selector">
        <div class="blog-post">

          <!-- Image -->
          <div press> 

            <a href="presses-details" class="post-img"><img src="{% static 'images/philippe.jpeg' %}" alt="Blog Post 1"></a>

          </div>

          <div class="bp-content">
            
            <!-- Meta data -->
            <div class="post-meta">
              <a href="#" class="post-date">
                <i class="fa fa-calendar-o"></i>
                <span>12 Septembre 2020</span>
              </a>
              
            </div><!-- / .meta -->

            <!-- Post Title -->
            <a href="presses-details" class="post-title"><h4>Condamné à 5 années de reclusion </h4></a>

            <!-- Blurb -->
            <p>Condamné à cinq années de réclusion, pour radicalisme religieux, le prophète Kacou Philippe s’est retiré dans son village natal, à Katadji. Ce, après avoir bénéficié de la grâce présidentielle. ...</p>

            <!-- Link -->
            <a href="presses-details" class="btn btn-small">Lire la suite</a>

          </div><!-- / .bp-content -->

        </div><!-- / .blog-post -->
      </div><!-- / .col-lg-4 -->
      <!-- Blog Post 1 -->
      <div class="col-md-4 blog-selector">
        <div class="blog-post">

          <!-- Image -->
          <div press> 

            <a href="presses-details" class="post-img"><img src="{% static 'images/philippe.jpeg' %}" alt="Blog Post 1"></a>

          </div>

          <div class="bp-content">
            
            <!-- Meta data -->
            <div class="post-meta">
              <a href="#" class="post-date">
                <i class="fa fa-calendar-o"></i>
                <span>12 Septembre 2020</span>
              </a>
              
            </div><!-- / .meta -->

            <!-- Post Title -->
            <a href="presses-details" class="post-title"><h4>Condamné à 5 années de reclusion </h4></a>

            <!-- Blurb -->
            <p>Condamné à cinq années de réclusion, pour radicalisme religieux, le prophète Kacou Philippe s’est retiré dans son village natal, à Katadji. Ce, après avoir bénéficié de la grâce présidentielle. ...</p>

            <!-- Link -->
            <a href="presses-details" class="btn btn-small">Lire la suite</a>

          </div><!-- / .bp-content -->

        </div><!-- / .blog-post -->
      </div><!-- / .col-lg-4 -->
      <!-- Blog Post 1 -->
      <div class="col-md-4 blog-selector">
        <div class="blog-post">

          <!-- Image -->
          <div press> 

            <a href="presses-details" class="post-img"><img src="{% static 'images/philippe.jpeg' %}" alt="Blog Post 1"></a>

          </div>

          <div class="bp-content">
            
            <!-- Meta data -->
            <div class="post-meta">
              <a href="#" class="post-date">
                <i class="fa fa-calendar-o"></i>
                <span>12 Septembre 2020</span>
              </a>
              
            </div><!-- / .meta -->

            <!-- Post Title -->
            <a href="presses-details" class="post-title"><h4>Condamné à 5 années de reclusion </h4></a>

            <!-- Blurb -->
            <p>Condamné à cinq années de réclusion, pour radicalisme religieux, le prophète Kacou Philippe s’est retiré dans son village natal, à Katadji. Ce, après avoir bénéficié de la grâce présidentielle. ...</p>

            <!-- Link -->
            <a href="presses-details" class="btn btn-small">Lire la suite</a>

          </div><!-- / .bp-content -->

        </div><!-- / .blog-post -->
      </div><!-- / .col-lg-4 -->
      <!-- Blog Post 1 -->
      <div class="col-md-4 blog-selector">
        <div class="blog-post">

          <!-- Image -->
          <div press> 

            <a href="presses-details" class="post-img"><img src="{% static 'images/philippe.jpeg' %}" alt="Blog Post 1"></a>

          </div>

          <div class="bp-content">
            
            <!-- Meta data -->
            <div class="post-meta">
              <a href="#" class="post-date">
                <i class="fa fa-calendar-o"></i>
                <span>12 Septembre 2020</span>
              </a>
              
            </div><!-- / .meta -->

            <!-- Post Title -->
            <a href="presses-details" class="post-title"><h4>Condamné à 5 années de reclusion </h4></a>

            <!-- Blurb -->
            <p>Condamné à cinq années de réclusion, pour radicalisme religieux, le prophète Kacou Philippe s’est retiré dans son village natal, à Katadji. Ce, après avoir bénéficié de la grâce présidentielle. ...</p>

            <!-- Link -->
            <a href="presses-details" class="btn btn-small">Lire la suite</a>

          </div><!-- / .bp-content -->

        </div><!-- / .blog-post -->
      </div><!-- / .col-lg-4 -->
      <!-- Blog Post 1 -->
      <div class="col-md-4 blog-selector">
        <div class="blog-post">

          <!-- Image -->
          <div press> 

            <a href="presses-details" class="post-img"><img src="{% static 'images/philippe.jpeg' %}" alt="Blog Post 1"></a>

          </div>

          <div class="bp-content">
            
            <!-- Meta data -->
            <div class="post-meta">
              <a href="#" class="post-date">
                <i class="fa fa-calendar-o"></i>
                <span>12 Septembre 2020</span>
              </a>
              
            </div><!-- / .meta -->

            <!-- Post Title -->
            <a href="presses-details" class="post-title"><h4>Condamné à 5 années de reclusion </h4></a>

            <!-- Blurb -->
            <p>Condamné à cinq années de réclusion, pour radicalisme religieux, le prophète Kacou Philippe s’est retiré dans son village natal, à Katadji. Ce, après avoir bénéficié de la grâce présidentielle. ...</p>

            <!-- Link -->
            <a href="presses-details" class="btn btn-small">Lire la suite</a>

          </div><!-- / .bp-content -->

        </div><!-- / .blog-post -->
      </div><!-- / .col-lg-4 -->
      <!-- Blog Post 1 -->
      <div class="col-md-4 blog-selector">
        <div class="blog-post">

          <!-- Image -->
          <div press> 

            <a href="presses-details" class="post-img"><img src="{% static 'images/philippe.jpeg' %}" alt="Blog Post 1"></a>

          </div>

          <div class="bp-content">
            
            <!-- Meta data -->
            <div class="post-meta">
              <a href="#" class="post-date">
                <i class="fa fa-calendar-o"></i>
                <span>12 Septembre 2020</span>
              </a>
              
            </div><!-- / .meta -->

            <!-- Post Title -->
            <a href="presses-details" class="post-title"><h4>Condamné à 5 années de reclusion </h4></a>

            <!-- Blurb -->
            <p>Condamné à cinq années de réclusion, pour radicalisme religieux, le prophète Kacou Philippe s’est retiré dans son village natal, à Katadji. Ce, après avoir bénéficié de la grâce présidentielle. ...</p>

            <!-- Link -->
            <a href="presses-details" class="btn btn-small">Lire la suite</a>

          </div><!-- / .bp-content -->

        </div><!-- / .blog-post -->
      </div><!-- / .col-lg-4 -->

       



      


     
    
                  
    </div><!-- / .row -->
    
    
    <!-- Pagination -->
    <div class="row">
      <nav class="blog-pagination text-center">
        <ul class="pagination">
          <li>
            <a href="#" aria-label="Previous">
              <span aria-hidden="true"><i class="fa fa-angle-double-left"></i></span>
            </a>
          </li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">...</a></li>
          <li><a href="#">7</a></li>
          <li>
            <a href="#" aria-label="Next">
              <span aria-hidden="true"><i class="fa fa-angle-double-right"></i></span>
            </a>
          </li>
        </ul>
      </nav>
    </div><!-- / .row -->
  </div><!-- / .container -->
  
{% endblock content %} 