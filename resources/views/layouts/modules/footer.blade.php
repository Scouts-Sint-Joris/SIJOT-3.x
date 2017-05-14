<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-6 footerleft ">
        <div class="logofooter"> Info</div>
        <p>
          Wij zijn een scoutsgroep gelegen te Sint-Jorislaan 11, Turnhout.
          Voor de rest hebben we elke zondag van de maand vergadering vanaf September tot Juni. Deze vergadering gaan door tussen,
          2u en 5u. Buiten de laatste zondag van de maand. Dan gaan de vergaderingen door vanaf 10u tot 5u.
        </p>
        <p><i class="fa fa-map-pin"></i> Sint-Jorislaan 11, 2300 Turnhout - Belgie</p>
        <p><i class="fa fa-envelope"></i> E-mail : <a href="mailto:contact@sint-joris-turnhout.com">contact@sint-joris-turnhout.com</a></p>

      </div>
      <div class="col-md-2 col-sm-6 paddingtop-bottom">
        <h6 class="heading7">LINKS</h6>
        <ul class="footer-ul">
          <li><a href="https://www.hopper.be/winkel"> Hopper (Winkel)</a></li>
          <li><a href="https://www.hopper.be/jeugdverblijf"> Hopper (Jeugdverblijven)</a></li>
          <li><a href="{{ route('disclaimer') }}"> Disclaimer</a></li>
          <li><a href="https://groepsadmin.scoutsengidsenvlaanderen.be/groepsadmin/lidworden?groep=A4102G"> Lid worden</a></li>
          <li><a href="{{ route('lease') }}"> Verhuur</a></li>
        </ul>
      </div>
      <div class="col-md-3 col-sm-6 paddingtop-bottom">
        <h6 class="heading7">LAATSTE NIEUWS</h6>
        <div class="post">
          @foreach($posts as $post)
            <p>{{ $post->title }} <span>{{ $post->created_at->format('F j, Y') }}</span></p>
          @endforeach
        </div>
      </div>
      <div class="col-md-3 col-sm-6 paddingtop-bottom">
        <h6 class="heading7">CONTACT</h6>
        <div class="footer-icons">
          <a class="icon icon-facebook" href=""><i class="fa fa-facebook"></i></a>
          <a class="icon icon-twitter" href=""><i class="fa fa-twitter"></i></a>
          <a class="icon icon-skype" href=""><i class="fa fa-skype"></i></a>
          <a class="icon icon-phone" href=""><i class="fa fa-phone"></i></a>
          <a class="icon icon-envelop" href=""><i class="fa fa-envelope"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>
<!--footer start from here-->

<div class="copyright">
  <div class="container">
    <div class="col-md-6">
      <p>© {{ date('Y') }} - Sint-Joris Turnhout</p>
    </div>
  </div>
</div>
