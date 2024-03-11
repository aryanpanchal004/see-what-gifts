$(window).click(function (e) {
    const searchDiv = document.querySelector("#searchBar-div");
    // console.log(searchDiv);
    const searchElement = searchDiv.querySelector("input");
    const searchBtn = searchDiv.querySelector(".btn");
    // console.log(searchBtn);

    if (e.target == searchElement) {
        return;
    }

    if (e.target == searchBtn) {
        return;
    }

    $("#search-output").html("");
});

$(".search-products").keyup(function () {
    console.log("Hello there");
    $("#search-output").html("");
    const searchQuery = $(this).val();
    $.ajax({
        method: "GET",
        url: "/products/search",
        data: {
            searchQuery: searchQuery,
        },
        success: function (response) {
            if (response == "no-result") {
                const notFoundHtml = `<div class="left-0 right-0 flex flex-col justify-center w-3/4 p-4 py-10 mx-auto bg-white rounded-lg shadow align-center"><h1 class="mx-auto text-3xl align-center">No Products Found!</h1></div>`;
                $("#search-output").html(notFoundHtml);
            } else if (response == "empty-state") {
                $("#search-output").html("");
            } else {
                $("#search-output").html(response);
            }
        },
    });
});
