<form role="search" method="get" class="journal-search" action="<?php echo esc_url(home_url("/")); ?>">
    <label class="visually-hidden" for="search-field"><?php esc_html_e("Search the journal", "kennyb-theme"); ?></label>
    <div class="input-group">
        <input type="search" id="search-field" class="form-control form-control-lg" name="s"
               value="<?php echo esc_attr(get_search_query()); ?>" placeholder="<?php esc_attr_e("Search the journal", "kennyb-theme"); ?>">
        <button type="submit" class="btn btn-primary"><?php esc_html_e("Search", "kennyb-theme"); ?></button>
    </div>
</form>
