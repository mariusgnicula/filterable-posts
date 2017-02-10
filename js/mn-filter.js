(function($) {

    $('.mn-filter ul li a').click(function(e) {

        var self = $(this),
            selfHref = self.attr('href').replace('#', ''),
            targetProduct = '.' + selfHref;

        self.parent('li').siblings('.active').removeClass('active');
        self.parent('li').addClass('active');

        if ( self.parent('li').hasClass('all') ) {

            $('.mn-filter-post__container .mn-filter-post').each(function() {

                var productSelf = $(this);

                if ( !productSelf.hasClass('visible') ) {

                    productSelf.fadeIn('fast');

                    productSelf.addClass('visible');

                }
            });

        } else {

            $('.mn-filter-post__container .mn-filter-post').each(function() {

                var productSelf = $(this);

                if ( productSelf.hasClass(selfHref) ) {

                    productSelf.fadeIn('fast');

                    productSelf.addClass('visible');

                } else {

                    productSelf.fadeOut('fast');

                    productSelf.removeClass('visible');

                }
            });
        }
    });

    $(document).ready(function(){

        var mnHash = window.location.hash;

        if ( mnHash ) {

            if ( mnHash === '#all' ) {

                $('.mn-filter ul li.all').addClass('active');

            } else {

                $('.mn-filter ul li a').each(function(){
                    var selfMN = $(this);

                    if ( selfMN.attr('href') === mnHash ) {
                        selfMN.parent('li').addClass('active');

                        var mnClass = selfMN.attr('href').replace('#', '');

                        $('.mn-filter-post__container .mn-filter-post').each(function() {

                            var productSelf = $(this);

                            if ( productSelf.hasClass(mnClass) ) {

                                productSelf.fadeIn('fast');

                                productSelf.addClass('visible');

                            } else {

                                productSelf.fadeOut('fast');

                                productSelf.removeClass('visible');

                            }
                        });
                    }
                });
            }

        } else {

            $('.mn-filter ul li.all').addClass('active');

        }

    });

}(jQuery));
