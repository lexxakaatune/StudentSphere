<?php 
declare(strict_types=1);

class PageController {
  public function index(): void {render('Homepage');}
  public function profile(): void {render('auth/profile');}
  public function about(): void {render('about');}
  public function contact(): void {render('contact');}
  public function blog(): void {render('blog');}
}