/*
 * page base action
 */
LP.use(['jquery' , 'util'] , function( exports , util ){
    'use strict';
    var $ = exports;
    // extent jquery , rewrite serialize method , for it 
    // would replace blank space to '+'
    var _tmpSerialize = $.fn.serialize;

    $.fn.serialize = function(){
        var data = _tmpSerialize.call(this);
        return data.replace(/\+/g , ' ');
    }

    // dom ready
    $(function(){
        /* 
         * 自动插入HTML 
         */
        $('[data-autoload]').each(function(){
            if( $(this).attr('run-auto-load') ) return;
            $(this).attr( 'run-auto-load' , 1 );
            var $self = $(this);
            var data  = LP.query2json( $self.data('autoload') );
            var api   = data.api;
            if ( api ) {
                delete data.api;
                LP.ajax(api, data, function(e){ 
                    e = e || ''; 
                    var html = e.html !== undefined ? e.html : e;
                    $self.html(html); 
                });
            }
        });
    });

    LP.action( 'logout' , function(){
        LP.ajax('logout' , '' , function(){
            LP.reload();
        });
    });

    // 1.scroll to body top
    // 2.show the login panel
    LP.action('login' , function(){
        // scroll to top
        util.trigger('login');
    });
    // for base action
    // for register
    LP.action( 'reg' , function(){
        LP.panel({
            url: '/login/?reg=1'
            , hideHead: true
            , width: 518
        });
    });


    // for fav
    LP.action('fav' , function( data ){
        var $dom = $( this );
        if( !util.lock( $dom ) )
            return;
        LP.ajax('fav' , data , function(){
            // plus element
            util.plus( $dom );
            var title = $dom.data('unfav-title');
            // change to up-fav
            $dom.attr({
                'data-a': 'unfav'
                ,'title': title
                ,'data-original-title': title
            });
        }, null, function( r ){
            util.unlock( $dom );
        });
    });
    // for fav
    LP.action('unfav' , function( data ){
        var $dom = $( this );
        if( !util.lock( $dom ) )
            return;
        LP.ajax('unfav' , data , function(){
            // reduce element
            util.reduce( $dom );
            var title = $dom.data('fav-title');
            // change to up-fav
            $dom.attr({
                'data-a': 'fav'
                ,'title': title
                ,'data-original-title': title
            });

            if( data.del ){
                $dom.closest('li')
                    .fadeOut();
            }
        }, null, function( r ){
            util.unlock( $dom );
        });
        return false;
    });

    // for msg
    var msgTemplate = "<div class=\"send-msg-panel\">\
        <textarea placeholder=" + _e("请输入私信内容") + "></textarea>\
        <div class=\"msg-tip\"></div>\
        <div class=\"mgt10 clearfix\"><a class=\"fr btn btn-green\" href=\"javascript:;\">" + _e('确定') + "</a></div>\
    </div>";
    var sendMsg = function( panel , data ){
        var $area = panel.$content.find('textarea');
        var $tip = panel.$content.find('.msg-tip');
        var val = $area.val();
        $tip.hide();
        if( !val ){
            util.error( $area );
        } else if( val.length > 300 ){
            util.error( $area );
            $tip.show().html(_e('私信最大长度为300'));
        } else {
            LP.ajax('addMsg' , {
                tid: data.tid,
                content: val
            } , function(){
                panel.close();
                LP.right(_e('私信发送成功'));
            });
        }
    }
    LP.action('send-msg' , function( data ){
        LP.panel({
            content: msgTemplate
            ,title: _e("发私信给") + " [ " + data.name + "]"
            ,onShow: function(){
                var panel = this;
                panel.$content
                    .find('textarea')
                    .focus()
                    .keydown(function( ev ){
                        if( ev.ctrlKey && ev.which == 13 ){
                            sendMsg( panel , data );
                        }
                    })
                    .end()
                    .find('a')
                    .click(function(){
                        sendMsg( panel , data );
                    });
            }
        })
    });

    // for link to 
    LP.action('link' , function(){
        var $dom = $(this);
        window.location.href = $dom.attr('href');
        return false;
    });

    $(function(){
        // click document , hide all the dropdown-menu
        var classname = ".dropdown-menu";
        $(classname).parent()
            .click(function( ev ){
                $(classname).hide();
                var $menu = $(this).find(classname)
                    .show();
                return $.contains( $menu[0] , ev.target );
            });
        $(document)
            .click(function( ev ){
                $('.dropdown-menu').hide();
            });
    });
    // for header normal function
    var headerReady = function(){
        // for base action
        var loginLoaded = false;
        $('#J_l-top').click( function(){
        //LP.action( 'login' , function(){
            var $wrap = $('#J_login-wrap').show();
            if( loginLoaded ) return;
            $wrap.click(function(){
                return false;
            });
            loginLoaded = true;
            $.get( '/login/' , function( r ){
                $wrap.find('.dropdown-menu-inner').html( r.html );
            } , 'json' );
        } );

        // change header dropdown menu
        $('.top-r-w').not('#J_l-top').mouseenter(function(){
            $(this).find('.dropdown-menu')
                .show();
        })
        .mouseleave(function(){
            $(this).find('.dropdown-menu')
                .hide();
        })
        .on('click' , '.dropdown-menu li' , function(){
            // set cookie
            var cookie = $(this).closest('.dropdown-menu').attr('c');
            if( !cookie ) return;
            var value = $(this).attr('c');
            LP.setCookie( cookie , value , 30 * 24 * 60 * 60 );
            location.href = location.href.replace(/#.*/ , '');
        });

        // get user messages
        (function(){
            if( !LP.isLogin() ){
                return;
            }
            var time = 30000;
            (function renderMessage(){
                LP.ajax('newMsg' , '' , function(r){
                    var msg = r.data.messages || {};
                    if( msg ){
                        var reply = msg.reply || 0;
                        var message = msg.message || 0;
                        var sysmsg = msg.sysMessage || 0;
                        var total = reply + message + sysmsg;
                        if( reply + message + sysmsg ){
                            var $msgNum = $('header .msg-num')
                                .show()
                                .html( total );
                            $msgNum.closest('.top-r-w')
                                .find('.J_reply')
                                .html(reply)
                                .end()
                                .find('.J_msg')
                                .html(message)
                                .end()
                                .find('.J_sysMessage')
                                .html(sysmsg);
                        }
                    }

                    setTimeout(renderMessage , time);
                });
            })();
        })();
    }

    $(headerReady);

    // for footer
    $(function(){
        $('.footer .langs').on('click' , 'a' , function(){
            LP.setCookie( 'lang' , $(this).attr('c') , 30 * 24 * 60 * 60 );
            location.href = location.href.replace(/#.*/ , '');
        });
    });

    // for back top
    $(function(){
        var $back = $('.back-top').click(function(){
            $('html,body').animate({
                scrollTop: 0
            } , 500 , '' , function(){
                $back.hide();
            });
        })[$(window).scrollTop() ? 'show' : 'hide']();

        if($.browser.msie && $.browser.version < 7){
            var timer = null ;
            var renderDom = function(){
                $goTopWrap.animate({
                    top: $(window).scrollTop() + $(window).height() - 200
                } , 200);
            }
            renderDom();
            $(window).scroll(function(){
                clearTimeout(timer);
                timer = setTimeout(renderDom,100);
            });
        } else {
            $(window).scroll(function(){
                if( $(window).scrollTop() < 100 ){
                    $back.hide();
                } else {
                    $back.show();
                }
            });
        }
    });

    // for tool tip
    $(function(){
        LP.use('tooltip' , function(){
            $('[data-toggle="tooltip"]').tooltip();
            return false;
        });
    });


    // for beautify select
    $(function(){

        LP.action("select-option" , function(){
            var index = $(this).index();
            $(this).closest('.select-widget')
                .find( '.input-val' )
                .html( $(this).text() );
            // change the select value
            var $select = $(this).closest('.select-widget')
                .prev();


            $select.children()
                .eq( index )
                .attr('selected' , 'selected' )
                .siblings()
                .removeAttr('selected');

            $select.trigger('change')
                .trigger('blur');
        });

        var tpl = '<label class="select-widget J_dropdown">\
            <span class="input-val"></span>\
            <span class="input-angle" style="border-left:none;"><i class="i-icon i-down-angle"></i></span>'
        var buildSelect = function( $select ){
            var aHtml = ['<ul class="dropdown-menu">'];
            $select.show().children()
                .each(function(){
                    aHtml.push( '<li data-a="select-option"><a>' + $(this).html() + '</a></li>' );
                });
            aHtml.push( '</ul></label>' );

            $( tpl + aHtml.join("") )
                .insertAfter( $select )
                .width( $select.width() )
                .find( '.input-val' )
                .html( $select.children().eq( $select.get(0).selectedIndex ).html() )
                .next()
                .click(function(){
                    $(this).next().toggle();
                    return false;
                });
            $select.hide();
        }
        $("select.j-select").each(function(){
            buildSelect( $(this) );
        })
        .change(function(){
            $(this).next()
                .find('.input-val')
                .html( $(this).children().eq( this.selectedIndex ).html() );
        })
        .bind("select-refresh" , function(){
            buildSelect( $(this) );
        });
    });


    // fix datepicker
    if( $(".j-datepicker" ).length ){
        LP.use( 'datepicker' , function(){
            $(function(){
                $(".j-datepicker" ).each(function(){
                    $(this).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        showOn: $(this).data('event') || 'click',
                        minDate: $(this).data("min-date"),
                        onSelect: function( date , context ){
                            var dateTime = $(this).datepicker('getDate');
                            $(context.input).find('.input-val')
                                .html( date )
                                .end()
                                .find( 'input' )
                                .val( +dateTime/1000)
                                .trigger('change')
                                .trigger('blur');
                        }
                    });
                });
            })
        });
    }
});