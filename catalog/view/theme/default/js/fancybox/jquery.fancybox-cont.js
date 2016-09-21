  $(document).ready(function() {
                
                                        $("a[rel=example_group]").fancybox({
                                'transitionIn'          : 'none',
                                'transitionOut'         : 'none',
                                'titlePosition'         : 'over',
                                'titleFormat'           : function(title, currentArray, currentIndex, currentOpts) {
                                        return '<span id="fancybox-title-over">Фото ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? '   ' + title : '') + '</span>';
                                }
                        });
                        
                });