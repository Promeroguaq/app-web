<footer id="footer" class="footer dark-background">
  <div class="container">
    <div class="footer-top py-5">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6">
          <div class="footer-info">
            <h4>Tour</h4>
            <p class="mb-0">Viaja con confianza y vive experiencias inolvidables.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="footer-contact">
            <h4>Contacto</h4>
            <p class="mb-1"><i class="bi bi-envelope me-2"></i> info@example.com</p>
            <p class="mb-0"><i class="bi bi-phone me-2"></i> +1 555 123 456</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-12">
          <div class="social-links">
            <h4>Síguenos</h4>
            <div class="d-flex gap-3">
              <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-facebook"></i></a>
              <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-instagram"></i></a>
              <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-twitter-x"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-bottom py-3 border-top border-secondary">
      <div class="container">
        <div class="text-center">
          <p class="mb-0"> {{ date('Y') }} Tour. Todos los derechos reservados.</p>
        </div>
      </div>
    </div>
  </div>
</footer>

<style>
/* Footer Styles */
#footer {
  background: var(--background-color);
  color: var(--contrast-color);
  padding: 2rem 0 0;
  position: relative;
  line-height: 1.6;
  width: 100%;
  margin-top: auto;
}

#footer .footer-top {
  padding: 60px 0 30px;
}

#footer h4 {
  color: var(--contrast-color);
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1.25rem;
  position: relative;
  padding-bottom: 0.75rem;
}

#footer h4::after {
  content: '';
  position: absolute;
  display: block;
  width: 40px;
  height: 3px;
  background: var(--accent-color);
  bottom: 0;
  left: 0;
}

#footer p {
  color: rgba(255, 255, 255, 0.8);
  margin-bottom: 0.5rem;
}

#footer .social-links a {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.1);
  color: var(--contrast-color);
  margin-right: 10px;
  transition: all 0.3s ease;
}

#footer .social-links a:hover {
  background: var(--accent-color);
  color: var(--contrast-color);
  transform: translateY(-3px);
}

#footer .footer-bottom {
  margin-top: 30px;
}

#footer .footer-bottom p {
  color: rgba(255, 255, 255, 0.6);
  font-size: 0.9rem;
  margin: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  #footer .footer-top {
    padding: 40px 0 10px;
  }
  
  #footer .footer-info,
  #footer .footer-contact,
  #footer .social-links {
    margin-bottom: 30px;
    text-align: center;
  }
  
  #footer h4::after {
    left: 50%;
    transform: translateX(-50%);
  }
  
  #footer .social-links {
    text-align: center;
  }
  
  #footer .social-links .d-flex {
    justify-content: center;
  }
}
</style>
