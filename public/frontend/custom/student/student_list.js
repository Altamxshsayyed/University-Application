var ajax_table;
var tableContainer;

var Student = (function () {
    var StudentList = function () {
        $.fn.serializeObject = function () {
            var obj = {};
            $.each(this.serializeArray(), function (i, o) {
                var n = o.name,
                    v = o.value;

                obj[n] =
                    obj[n] === undefined
                        ? v
                        : $.isArray(obj[n])
                        ? obj[n].concat(v)
                        : [obj[n], v];
            });
            return obj;
        };
        tableContainer = $(".table-container").parent();
        ajax_table = $("#student_table").DataTable({
            ordering: false,
            select: false,
            searching: false,
            serverSide: true,
            responsive: true,
            lengthMenu: [
                [10, 25, 50, 75, 100],
                [10, 25, 50, 75, 100],
            ],
            pageLength: 25,
            ajax: {
                url: "fetch_student",
                type: "POST",
                data: function (d) {
                    d.form = $("#filterData").serializeObject();
                },
                dataSrc: function (res) {
                    return res.data;
                },
                error: function () {
                    console.error("Error fetching data.");
                },
            },
            lengthChange: true,
        });

        $(document).on("click", ".submit_filter", function (e) {
            e.preventDefault();
            ajax_table.ajax.reload();
            e.preventDefault();
        });
    };

    return {
        handleList: function () {
            StudentList();
        },
    };
})();
