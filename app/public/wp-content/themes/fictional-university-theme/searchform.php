<form class="search-form" method="GET" action="<?php echo esc_url(site_url('/')); ?>">
    <label class="headline headline--medium" for="s">Perform a New Search:</label>
    <div class="search-form-row">
        <input class="s" type="search" name="s" id="s" placeholder="What are you looking for?" autocomplete="off">
        <input class="search-submit" type="submit" value="Search">
    </div>
</form>
