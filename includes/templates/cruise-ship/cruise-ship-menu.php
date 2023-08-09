<div id="ship-menu">
    <span class="mobile-label">Quick Links <span class="fa fa-bars"></span></span>
    <div class="row">
        <div class="col-md-12 no-padding">
            <div id="cruise-ship-menu" class="no-padding cruise-ship-menu">
                <ul class="ship-quick-menu">
                    <li class="label">Quick Links</li>
                    <?php if ($ship->ship_accommodation) { ?>
                    <li><a href="#ship-accommodation">Accommodation</a></li>
                    <?php } if ($ship->ship_entertainment) { ?>
                    <li><a href="#ship-entertainment">Entertainment</a></li>
                    <?php } if ($ship->ship_dining) { ?>
                    <li><a href="#ship-dining">Dining</a></li>
                    <?php } if ($ship->ship_enrichment) { ?>
                    <li><a href="#ship-enrichment">Enrichment</a></li>
                    <?php } if ($ship->ship_health_fitness) { ?>
                    <li><a href="#ship-health_fitness">Health &amp; Fitness</a></li>
                    <?php } if ($ship->ship_deckplans) { ?>
                    <li><a href="#ship-deckplans">Deckplans</a></li>
                    <?php } if ($ship->ship_facts) { ?>
                    <li class="hidden-md-up"><a href="#ship-facts">Ship Facts</a></li>
                    <?php } ?>
                    <li><a href="#ship-about">Top <span class="material-symbols-outlined">expand_less</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>