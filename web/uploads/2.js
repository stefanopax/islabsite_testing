<script type="text/javascript" src="http://islab.di.unimi.it/content/islab_site/media/com_islabteachpages/js/jquerynews.js"></script>

<script type="text/javascript" src="http://islab.di.unimi.it/content/islab_site/media/com_islabteachpages/js/jquery.jfeed.pack.js"></script>
  <script type="text/javascript">
jQuery(function() {
    jQuery.getFeed({
        url: 'http://islab.di.unimi.it/iNewsMail/feed.php?channel=bdlab1',
        success: function(feed) {
            var html = '';
            for(var i = 0; i < feed.items.length && i < 10; i++) {
            
                var item = feed.items[i];
                html += '<div class="body-news">'
                + '<b>'
                + item.title
                + '</b><br />'
                + '<div>'
                + item.description
                + '</div>'
                + ' </div>';
            }
            jQuery('#newsresult').append(html);
        }    
    });
});
</script>