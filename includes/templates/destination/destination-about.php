<div class="container destination-about">
    <div class="row">
        <div class="col-md-8 no-padding">
            
            <h2>About <?php echo $destination->destination_title; ?></h2>
            
            <?php echo $destination->destination_about; ?>
        </div>
        <div class="col-md-4 sidebar-ads">
            <?php dynamic_sidebar('udg-ads'); ?>
        </div>
    </div>
</div>