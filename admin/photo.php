<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Bootstrap Photo Gallery Demo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

    <link href="dist/jquery.bsPhotoGallery-min.css" rel="stylesheet">
    <script src="dist/jquery.bsPhotoGallery-min.js"></script>

    </script>
    <script>
    $(document).ready(function(){
        $('ul.first').bsPhotoGallery({
            "classes" : "col-xl-3 col-lg-2 col-md-4 col-sm-4",
            "hasModal" : true,
            "shortText" : false
        });
    });
    </script>
</head>
<style>
    /**************STYLES ONLY FOR DEMO PAGE**************/
    @import url(https://fonts.googleapis.com/css?family=Bree+Serif);
    body {
        background:#ebebeb;
    }
</style>
<body>
<div class="container">
    <div class="row" style="text-align:center; border-bottom:1px dashed #ccc;  padding:30px 0 20px 0; margin-bottom:40px;">
        <div class="col-lg-12">
            <h3 style="font-family:'Bree Serif', arial; font-weight:bold; font-size:30px;">
                <a style="text-decoration:none; color:#666;" href="http://michaelsoriano.com/create-a-responsive-photo-gallery-with-bootstrap-framework/">Bootstrap Photo Gallery jQuery plugin <span style="color:red;">Demo</span></a>
            </h3>
            <p>Resize your browser and watch the gallery adapt to the view port size. Clicking on an image will activate the Modal. Click <strong><a style="color:red" href="http://michaelsoriano.com/create-a-responsive-photo-gallery-with-bootstrap-framework/">Here</a></strong> to go back to the tutorial</p>
        </div>
    </div>

    <ul class="row first">
        <li>
            <img alt="Rocking the night away"  src="http://demo.michaelsoriano.com/images/photodune-174908-rocking-the-night-away-xs.jpg">
            <p>Consectetur adipiscing elit</p>
        </li>
        <li>
            <img alt="Yellow sign"  src="http://demo.michaelsoriano.com/images/photodune-287182-blah-blah-blah-yellow-road-sign-xs.jpg">
            <p>Lorem ipsum dolor sit amet, labore et dolore magna aliqua. Ut enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Colors"  src="http://demo.michaelsoriano.com/images/photodune-460760-colors-xs.jpg">
            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
        </li>
        <li>
            <img alt="Retro party"  src="http://demo.michaelsoriano.com/images/photodune-461673-retro-party-xs.jpg">
            <p>Lorem, do eiusmod tempor incid Ut enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Technology soup"  src="http://demo.michaelsoriano.com/images/photodune-514834-touchscreen-technology-xs.jpg">
            <p>Do eiusmod tempor</p>
        </li>
        <li>
            <img alt="Legal docs"  src="http://demo.michaelsoriano.com/images/photodune-916206-legal-xs.jpg" data-bsp-large-src="http://demo.michaelsoriano.com/images/photodune-916206-legal-large.jpg">
            <p>Eiusmod tempor enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Nature shot"  src="http://demo.michaelsoriano.com/images/photodune-1062948-nature-xs.jpg">
            <p>Adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Kid with camera" src="http://demo.michaelsoriano.com/images/photodune-1471528-insant-camera-kid-xs.jpg" data-bsp-large-src="http://demo.michaelsoriano.com/images/photodune-1471528-insant-camera-kid-large.jpg">
            <p>Lorem ipsum dolor sit amet, labore et dolore magna aliqua. Ut enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Relax and Chill" src="http://demo.michaelsoriano.com/images/photodune-2255072-relaxed-man-xs.jpg">
            <p>Eiusmod tempor enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Cool colors" src="http://demo.michaelsoriano.com/images/photodune-2360379-colors-xs.jpg">
            <p>Consectetur adipiscing elit</p>
        </li>
        <li>
            <img alt="Jump over"  src="http://demo.michaelsoriano.com/images/photodune-2360571-jump-xs.jpg">
            <p>Lorem ipsum dolor sit amet, labore et dolore magna aliqua. Ut enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Culture business" src="http://demo.michaelsoriano.com/images/photodune-2361384-culture-for-business-xs.jpg">
            <p>Adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
        </li>

        <li>
            <img alt="Spaghetti bitch" src="http://demo.michaelsoriano.com/images/photodune-2441670-spaghetti-with-tuna-fish-and-parsley-s.jpg">
            <p>Lorem ipsum dolor sit amet, labore et dolore magna aliqua. Ut enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Budget this"  src="http://demo.michaelsoriano.com/images/photodune-2943363-budget-xs.jpg">
            <p>Adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Street art"  src="http://demo.michaelsoriano.com/images/photodune-3444921-street-art-xs.jpg">
            <p>Consectetur adipiscing elit, re magna aliqua. Ut enim ad minim veniam</p>
        </li>


        <li>
            <img alt="Insurance and stuff"  src="http://demo.michaelsoriano.com/images/photodune-3552322-insurance-xs.jpg">
            <p>Ut enim ad minim veniam</p>
        </li>

        <li>
            <img alt="Food Explosion"  src="http://demo.michaelsoriano.com/images/photodune-3807845-food-s.jpg">
            <p>Eiusmod tempor enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Office worker sad" src="http://demo.michaelsoriano.com/images/photodune-3835655-down-office-worker-xs.jpg">
            <p>Ut enim ad minim veniam</p>
        </li>

        <li>
            <img alt="" src="http://demo.michaelsoriano.com/images/photodune-4619216-ui-control-knob-regulators-xs.jpg">
            <p>Do eiusmod tempor</p>
        </li>

        <li>
            <img alt="Health" src="http://demo.michaelsoriano.com/images/photodune-5771958-health-xs.jpg">
            <p>Lorem ipsum dolor sit amet, labore et dolore magna aliqua. Ut enim ad minim veniam</p>
        </li>
        <li>
            <img  alt="Constant consecutuir" src="http://demo.michaelsoriano.com/images/photodune-268693-businesswoman-using-laptop-outdoors-xs.jpg"><!--no alt tag-->
            <p>Consectetur adipiscing elit, re magna aliqua. Ut enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Search code" src="http://demo.michaelsoriano.com/images/photodune-352207-search-of-code-s.jpg">
            <p>Adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
        </li>

        <li>
            <img alt="Pountac" src="http://demo.michaelsoriano.com/images/photodune-247190-secret-email-xs.jpg"><!--no alt tag, no text-->
            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
        </li>
        <li>
            <img alt="Budget again" src="http://demo.michaelsoriano.com/images/photodune-2943363-budget-xs.jpg">
            <p>Adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Some alt tag" src="http://demo.michaelsoriano.com/images/photodune-3444921-street-art-xs.jpg"><!--no alt-->
            <p>Consectetur adipiscing elit, re magna aliqua. Ut enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Insurance boy"  src="http://demo.michaelsoriano.com/images/photodune-3552322-insurance-xs.jpg">
            <p>Ut enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Food service"  src="http://demo.michaelsoriano.com/images/photodune-3807845-food-s.jpg">
            <p>Eiusmod tempor enim ad minim veniam</p>
        </li>
        <li>
            <img alt="Dopamine high"  src="http://demo.michaelsoriano.com/images/photodune-3835655-down-office-worker-xs.jpg">
            <p>Ut enim ad minim veniam</p>
        </li>

    </ul>




</div> <!-- /container -->


<style>
    ul[data-bsp-ul-index] {
        padding:0 0 0 0;
        margin:0 0 40px 0;
    }
    ul[data-bsp-ul-index] li {
        list-style:none;
        margin-bottom:10px;
    }

    #bsPhotoGalleryModal .modal-content {
        border-radius:0;
    }
    #bsPhotoGalleryModal .modal-dialog img {
        text-align:center;
        margin:0 auto;
        width:100%;
    }
    #bsPhotoGalleryModal .modal-body {
        padding:0px !important;
        text-align: center;
    }
    #bsPhotoGalleryModal .bsp-text-container {
        text-align:left;
        padding-top:10px;
    }

    #bsPhotoGalleryModal .bsp-close {
        position: absolute;
        right: -8px;
        top: -7px;
        background: rgba(255, 255, 255, 0.89);
        padding: 0px 8px 5px;
        border: 1px solid rgba(0,0,0,.49);
        border-radius: 50%;
    }
    #bsPhotoGalleryModal .bsp-close:hover {
        cursor: pointer;
        opacity:.6;
    }

    #bsPhotoGalleryModal .bsp-close img {
        width: 13px;
        height: 13px;
    }

    .bspHasModal {
        cursor: pointer;
    }
    .bspText.bspShortText {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .bspText {
        color:#666;
        font-size:11px;
        margin-bottom:10px;
        padding:12px;
        background:#fff;
    }

    #bsPhotoGalleryModal a.bsp-controls img {
        width: 20px;
        height: 35px;
    }
    a.bsp-controls,
    a.bsp-controls:visited,
    a.bsp-controls:active {
        position: absolute;
        top: 46%;
        background: rgba(255, 255, 255, 0.49);
    }

    a.bsp-controls.next {
        right:0px;
        border-top: 1px solid rgba(0,0,0,.49);
        border-left: 1px solid rgba(0,0,0,.49);
        border-bottom: 1px solid rgba(0,0,0,.49);
        border-bottom-left-radius: 4px;
        border-top-left-radius: 4px;
        padding-left: 4px;
        border-right:none;
    }
    a.bsp-controls.previous {
        left:0px;
        border-top: 1px solid rgba(0,0,0,.49);
        border-right: 1px solid rgba(0,0,0,.49);
        border-bottom: 1px solid rgba(0,0,0,.49);
        border-bottom-right-radius: 4px;
        border-top-right-radius: 4px;
        padding-right: 4px;
        border-left:none;
    }
    a.bsp-controls:hover {
        opacity:.6;
        text-shadow: none;
    }
    .bsp-text-container {
        clear:both;
        display:block;
        padding-bottom: 5px;
    }
    #bsPhotoGalleryModal h6{
        margin-bottom: 0;
        font-weight: bold;
        color: #000;
        font-size: 14px;
        padding-left: 12px;
        padding-right: 12px;
        margin-bottom: 5px;
    }
    #bsPhotoGalleryModal .pText {
        font-size: 11px;
        margin-bottom: 0px;
        padding: 0 12px 5px;
    }

    .bspImgWrapper {
        overflow: hidden;
        height: 100px;
        background-position-x: center !important;
        background-position-y: center !important;
        background-size: cover !important;
    }

    @media (min-width: 992px){
        #bsPhotoGalleryModal .modal-lg {
            max-width: 1000px;
        }
    }

    @media screen and (max-width: 575px){
        .bspImgWrapper {
            height: 150px;
        }
    }
</style>

<script>
    (function($) {
        "use strict";
        $.fn.bsPhotoGallery = function(options) {

            var settings = $.extend({}, $.fn.bsPhotoGallery.defaults, options);
            var id = generateId();
            var classesString = settings.classes;
            var classesArray = classesString.split(" ");
            var clicked = {};

            function getCurrentUl(){
                return 'ul[data-bsp-ul-id="'+clicked.ulId+'"][data-bsp-ul-index="'+clicked.ulIndex+'"]';
            }
            function generateId() {
                var ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                var ID_LENGTH = 4;
                var out = '';
                for (var i = 0; i < ID_LENGTH; i++) {
                    out += ALPHABET.charAt(Math.floor(Math.random() * ALPHABET.length));
                }
                return 'bsp-'+out;
            }
            function createModalWrap(){

                if($('#bsPhotoGalleryModal').length !== 0){
                    return false;
                }

                var modal = '';
                modal += '<div class="modal fade" id="bsPhotoGalleryModal" tabindex="-1" role="dialog"';
                modal += 'aria-labelledby="myModalLabel" aria-hidden="true">';
                modal += '<div class="modal-dialog modal-lg"><div class="modal-content">';
                modal += '<div class="modal-body"></div></div></div></div>';
                $('body').append(modal);

            }
            function showHideControls(){
                var total = $(getCurrentUl()+' li[data-bsp-li-index]').length;

                if(total === clicked.nextImg){
                    $('a.next').hide();
                }else{
                    $('a.next').show()
                }
                if(clicked.prevImg === -1){
                    $('a.previous').hide();
                }else{
                    $('a.previous').show()
                }
            }

            function getSrcfromStyle(istr){
                // return istr.replace(/url\(\"/g,'').replace(/\"\)/g,'');  //**DOESNT WORK IN SAFARI/MAC https://github.com/michaelsoriano/bootstrap-photo-gallery/issues/17
                return istr.replace('"','')
                    .replace("'",'')
                    .replace('"','')
                    .replace("'",'')
                    .replace('url(','')
                    .replace(')','');
            }

            function showModal(){

                var bImgString = $(this).find('.bspImgWrapper')[0].style.backgroundImage;
                var src = getSrcfromStyle(bImgString);
                var index = $(this).attr('data-bsp-li-index');
                var ulIndex = $(this).parent('ul').attr('data-bsp-ul-index');
                var ulId = $(this).parent('ul').attr('data-bsp-ul-id');
                var pText = $(this).find('p').html();
                var modalText = typeof pText !== 'undefined' ? pText : 'undefined';


                clicked.img = src;
                clicked.prevImg = parseInt(index) - parseInt(1);
                clicked.nextImg = parseInt(index) + parseInt(1);
                clicked.ulIndex = ulIndex;
                clicked.ulId = ulId;

                $('#bsPhotoGalleryModal').modal();

                var html = '';
                var img = '<img src="' + clicked.img + '" class="img-responsive bsp-modal-main-image"/>';

                html += img;
                html += '<span class="bsp-close"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDEyOCAxMjgiIGhlaWdodD0iMTI4cHgiIGlkPSLQodC70L7QuV8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAxMjggMTI4IiB3aWR0aD0iMTI4cHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxnPjxwb2x5Z29uIGZpbGw9IiMzNzM3MzciIHBvaW50cz0iMTIzLjU0Mjk2ODgsMTEuNTkzNzUgMTE2LjQ3NjU2MjUsNC41MTg1NTQ3IDY0LjAwMTk1MzEsNTYuOTMwNjY0MSAxMS41NTk1NzAzLDQuNDg4MjgxMyAgICAgNC40ODgyODEzLDExLjU1OTU3MDMgNTYuOTI3MjQ2MSw2My45OTcwNzAzIDQuNDU3MDMxMywxMTYuNDA1MjczNCAxMS41MjQ0MTQxLDEyMy40ODE0NDUzIDYzLjk5ODUzNTIsNzEuMDY4MzU5NCAgICAgMTE2LjQ0MjM4MjgsMTIzLjUxMTcxODggMTIzLjUxMjY5NTMsMTE2LjQ0MTQwNjMgNzEuMDczMjQyMiw2NC4wMDE5NTMxICAgIi8+PC9nPjwvc3ZnPg=="></span>';
                html += '<div class="bsp-text-container">';

                if(typeof pText !== 'undefined'){
                    html += '<p class="pText">'+pText+'</p>'
                }
                html += '</div>';

                if(settings.showControl){
                    html += '<a class="bsp-controls next" data-bsp-id="'+clicked.ulId+'" href="'+ (clicked.nextImg) + '">';
                    html += '<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGhlaWdodD0iNTEycHgiIGlkPSJMYXllcl8xIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgd2lkdGg9IjUxMnB4IiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48cGF0aCBkPSJNMjk4LjMsMjU2TDI5OC4zLDI1NkwyOTguMywyNTZMMTMxLjEsODEuOWMtNC4yLTQuMy00LjEtMTEuNCwwLjItMTUuOGwyOS45LTMwLjZjNC4zLTQuNCwxMS4zLTQuNSwxNS41LTAuMmwyMDQuMiwyMTIuNyAgYzIuMiwyLjIsMy4yLDUuMiwzLDguMWMwLjEsMy0wLjksNS45LTMsOC4xTDE3Ni43LDQ3Ni44Yy00LjIsNC4zLTExLjIsNC4yLTE1LjUtMC4yTDEzMS4zLDQ0NmMtNC4zLTQuNC00LjQtMTEuNS0wLjItMTUuOCAgTDI5OC4zLDI1NnoiLz48L3N2Zz4="/></a>';
                    html += '<a class="bsp-controls previous" data-bsp-id="'+clicked.ulId+'" href="' + (clicked.prevImg) + '">';
                    html += '<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGhlaWdodD0iNTEycHgiIGlkPSJMYXllcl8xIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgd2lkdGg9IjUxMnB4IiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48cG9seWdvbiBwb2ludHM9IjM1MiwxMjguNCAzMTkuNyw5NiAxNjAsMjU2IDE2MCwyNTYgMTYwLDI1NiAzMTkuNyw0MTYgMzUyLDM4My42IDIyNC43LDI1NiAiLz48L3N2Zz4="/></a></a>';
                }
                $('#bsPhotoGalleryModal .modal-body').html(html);
                $('.bsp-close').on('click', closeModal);
                showHideControls();
            }

            function closeModal(){
                $('#bsPhotoGalleryModal').modal('hide');
            }

            function nextPrevHandler(){

                var ul = $(getCurrentUl());
                var index = $(this).attr('href');

                var istr = ul.find('li[data-bsp-li-index="'+index+'"] .bspImgWrapper')[0].style.backgroundImage;
                var src = getSrcfromStyle(istr);
                var pText = ul.find('li[data-bsp-li-index="'+index+'"] p').html();
                var modalText = typeof pText !== 'undefined' ? pText : 'undefined';


                $('#bsPhotoGalleryModal .modal-body img.bsp-modal-main-image').attr('src', src);
                var txt = '';
                if(typeof pText !== 'undefined'){
                    txt += '<p class="pText">'+pText+'</p>'
                }
                $('.bsp-text-container').html(txt);

                clicked.prevImg = parseInt(index) - 1;
                clicked.nextImg = parseInt(clicked.prevImg) + 2;

                if($(this).hasClass('previous')){
                    $(this).attr('href', clicked.prevImg);
                    $('a.next').attr('href', clicked.nextImg);
                }else{
                    $(this).attr('href', clicked.nextImg);
                    $('a.previous').attr('href', clicked.prevImg);
                }

                showHideControls();
                return false;
            }
            function clearModalContent(){
                $('#bsPhotoGalleryModal .modal-body').html('');
                clicked = {};
            }


            //START OF LOGIC//

            this.each(function(i){
                //ul
                var items = $(this).find('li');
                $(this).attr('data-bsp-ul-id', id);
                $(this).attr('data-bsp-ul-index', i);

                items.each(function(x){
                    var theImg = $(this).find('img');
                    var theText = $(this).find('p');
                    var src = theImg.attr('src');

                    $(this).addClass(classesString);
                    $(this).attr('data-bsp-li-index', x);


                    theImg.wrap('<div class="bspImgWrapper" style="background:url(\''+src+'\');"></div>');
                    theText.addClass('bspText');

                    if(settings.shortText === true){
                        theText.addClass('bspShortText');
                    }

                    theImg.remove();

                    if(settings.hasModal === true){
                        $(this).addClass('bspHasModal');
                        $(this).on('click', showModal);
                    }
                });
            })

            if(settings.hasModal === true){
                //this is for the next / previous buttons
                $(document).on('click', 'a.bsp-controls[data-bsp-id="'+id+'"]', nextPrevHandler);
                $(document).on('hidden.bs.modal', '#bsPhotoGalleryModal', clearModalContent);
                //start init methods
                createModalWrap();
            }

            return this;
        };
        /*defaults*/
        $.fn.bsPhotoGallery.defaults = {
            'classes' : 'col-xl-2 col-lg-2 col-md-2 col-sm-4',
            'showControl' : true,
            'hasModal' : true,
            'shortText' : true
        }


    }(jQuery));
</script>



</body>


</html>