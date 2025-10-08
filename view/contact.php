<?php render('layout/header'); ?>

  <section class="contact__hero">
    <figure class="contact__hero__figure">
      <figcaption class="big-text">
        Contact Us
      </figcaption>
    </figure>
  </section>

  <main class="main">
    <article class="contact">
      <h2 class="h2">Our Location</h2>
      <address>
          12D, Psychatric/Ohiamini Road, Port Harcourt<br>
          River State, Nigeria
          <br><br>
          Dial: <a href="tel:+2348037227008">my phone number</a>
      </address>
      <ul class="contact__social-handle none">
          <li>
              <a href="https://www.linkedin.com" target="_blank">
                  <i class="fa-brands fa-linkedin-in"></i>
              </a>
          </li>
          <li>
              <a href="https://www.twitter.com" target="_blank">
                  <i class="fa-brands fa-twitter"></i>
              </a>
          </li>
          <li>
              <a href="https://www.facebook.com" target="_blank">
                  <i class="fa-brands fa-facebook-f"></i>
              </a>
          </li>
          <li>
              <a href="https://www.instgram.com" target="_blank">
                  <i class="fa-brands fa-instagram"></i>
              </a>
          </li>
      </ul>
    </article>
    <article class="contact">
      <h2 class="h2">Contact Us</h2>
      <form class="contact__form" action="https://httpbin.org/get" method="get">
        <fieldset class="contact__fieldset">
          <legend class="offscreen">Send Us A Message</legend>
          <p class="contact__p">
              <label class="offscreen" for="name">Name:</label>
              <input class="contact__input" type="text" name="name" id="name" placeholder="your name" required>
          </p>
          <p class="contact__p">
              <label class="offscreen" for="email">Email:</label>
              <input class="contact__input" type="email" name="email" id="email" placeholder="your email" required>
          </p>
          <p class="contact__p">
              <label class="offscreen" for="message">Your message:</label>
              <br>
              <textarea class="contact__textarea" name="message" id="message" cols="30" rows="10" placeholder="Type your message here*"></textarea>
          </p>
        </fieldset>
        <button class="btn" type="submit">Send</button>
        <button class="btn" type="reset">Reset</button>
      </form>
    </article>
  </main>

<?php render('layout/footer'); ?>