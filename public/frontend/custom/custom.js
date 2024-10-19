function clearAjaxErrors(el) {
    if (el) {
        $(el).find(".ajax-error").html("");
        $(el).find(".ajax-msg").html("");
    } else {
        $(".ajax-error").html("");
        $(".ajax-msg").html("");
    }
}

function fillAjaxForm(data) {
    Object.keys(data).map(function (key) {
        $("#ajax-form")
            .find('[name="' + key + '"]')
            .val(data[key]);
    });
}

$(document).on("click", ".delete_record", function (e) {
    e.preventDefault();
    var id = $(this).attr("id");
    var route = $(this).attr("route");
    var tabel_id = $(this).attr("table_id");
    if (id != " ") {
        bootbox.confirm({
            message: "Are you sure you want to delete it?",
            size: "small",
            buttons: {
                confirm: {
                    label: "Yes",
                    className: "btn-success bg-glow",
                },
                cancel: {
                    label: "No",
                    className: "btn-danger bg-glow",
                },
            },
            callback: function (result) {
                if (result == 1) {
                    $.ajax({
                        type: "GET",
                        url: route + "/" + id,
                        success: function (result) {
                            $("#table-msg-content").html(
                                "Record deleted successfully"
                            );
                            $(".table-msg-alert").removeClass("d-none");
                            setTimeout(function () {
                                $(".table-msg-alert").addClass("d-none");
                            }, 2000);
                            scrollTo($(".table-msg-alert"), -200);
                            ajax_table.ajax.reload();
                        },
                    });
                }
            },
        });
    }
});

// Submit normal form start
$("#ajax_form").on("submit", function (e) {
    e.preventDefault();

    var form_id = $(this).attr("id");
    var route = $(this).attr("route");

    var fd = new FormData(this);

    $.ajax({
        url: app_base_path + "/" + route,
        type: "POST",
        dataType: "json",
        data: fd,
        processData: false,
        contentType: false,
        success: function (data) {
            if ($.isEmptyObject(data.error)) {
                $("html, body").animate({ scrollTop: 0 }, "fast");
                console.log(data);

                if (data.success === false) {
                    $("#" + form_id)
                        .find(".ajax-msg")
                        .html(
                            '<div class="alert alert-danger d-flex align-items-center" role="alert"><span class="alert-icon text-success me-2"><i class="fas fa-ban ti-xs"></i></span>' +
                                data.msg +
                                "</div>"
                        );
                    $(".ajax-msg").fadeOut(2000, function () {});
                } else {
                    $("#" + form_id)
                        .find(".ajax-msg")
                        .html(
                            '<div class="alert alert-success d-flex align-items-center" role="alert"><span class="alert-icon text-success me-2"><i class="fas fa-check ti-xs"></i></span>' +
                                data.msg +
                                "</div>"
                        );
                    $(".ajax-msg").fadeOut(2000, function () {
                        window.location.href = data.redirect_url;
                    });
                }
            } else {
                printErrorMsg(data.error);
            }
        },
        error: function (err) {
            console.log(err);
        },
    });

    function printErrorMsg(msg) {
        $.each(msg, function (key, value) {
            console.log(key);
            const keys = key.split(".")[0];
            $("." + keys + "_err").text(value);
        });
    }
});
