
/*=======navbar========*/


    
    $(document).on('click',function (event) {
       
        var clickover = $(event.target);
        var _opened = $("button.main-btn").hasClass("show");
        if (_opened === true && !clickover.hasClass("navbar-toggler")) {
            $("button.navbar-toggler").click();
        }
    });








/*========dropdown==========*/
// $(document).ready(function () {
//   $(document).click(function (event) {
//       var clickover = $(event.target);
//       var _opened = $("ul.absolute").hasClass("main-btn show");
//       if (_opened === true && !clickover.hasClass("main-btn")) {
//           $("button.main-btn").click();
//       }
//   });
// });


/*========add class for dropdown==========*/
