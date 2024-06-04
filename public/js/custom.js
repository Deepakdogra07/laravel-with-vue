
/*=======navbar========*/
// onMounted(() => {
//   $(function () {
//     $(document).click(function (event) {
//       var clickover = $(event.target);
//       var _opened = $(".navbar-collapse").hasClass("show");
//       if (_opened === true && !clickover.hasClass("navbar-toggler")) {
//         $("button.navbar-toggler").click();
//       }
//     });
//   });
// });

$(document).ready(function () {
    $(document).on('click ','input.recommended_checkbox', function () 
    {
        // console.log($(this),'123456')
        if($(this).parent('div').hasClass("active-checkbox")){
            $(this).parent('div').removeClass("active-checkbox");
        }else{
            $(this).parent('div').addClass("active-checkbox");
        }
    });
});


$(document).ready(function () {
    $(document).on( 'padding_remove', function () 
    {
        // console.log($(this),'123456')
        if($(this).parent('div').hasClass("active-checkbox")){
            $(this).parent('div').removeClass("active-checkbox");
        }else{
            $(this).parent('div').addClass("active-checkbox");
        }
    });
});

// $(document).click(function (event) {
//     setTimeout(function(){      
        
//         var clickover = $(event.target);
//         var _opened = $(".user_dropdown li > ul").css('display');
//         console.log('clickover',clickover)
//         console.log('clickover',event.target)
//         console.log('_opened',_opened)
        
//         if (_opened === 'block' && !clickover.hasClass("user_dropdown_btn")) {
//             console.log('hide now')
//             $(".user_dropdown li > ul").hide();
//         }
//     },500);
// });


// $(function () {
//     $(document).click(function (event) {
//         var clickover = $(event.target);
//         var _opened = $(".navbar-collapse").hasClass("show"); // Adjusted the class check
//         if (_opened === true && !clickover.hasClass("navbar-toggler")) {
//             $("button.navbar-toggler").click();
//         }
//     });
// });
