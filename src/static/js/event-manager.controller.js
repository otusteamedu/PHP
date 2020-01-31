$(document).ready(() => {

    let filter_form = "#filter_events_form";
    let urls = {
        filtered_events: {
            html: $("#filtered_as_html_url").val(),
            json: $("#filtered_as_json_url").val()
        },
        priority_event: {
            html: $("#priority_as_html_url").val(),
            json: $("#priority_as_json_url").val()
        }
    };

    let conditionPrefix = $("#conditionPrefix").val() || "";

    let conditionFormCounter = 0;
    let conditionFilterCounter = 0;

    let event_condition_template_html = $("#event_condition_template").html();
    let event_conditions_container = $(".event_conditions_container");
    let filter_condition_template_html = $("#filter_condition_template").html();

    function bindConditionsForm() {

        $(".add_condition")
            .unbind("click")
            .bind("click", function () {
                let condName = `${conditionPrefix}${++conditionFormCounter}`;
                $(event_conditions_container)
                    .append(event_condition_template_html);
                $(event_conditions_container)
                    .find(".condition_input")
                    .last()
                    .attr("name", condName)
                    .parent()
                    .find(".condition_label")
                    .text(condName);
                bindConditionsForm();
            });

        $(".delete_condition")
            .unbind("click")
            .bind("click", function () {
                $(this)
                    .parent()
                    .remove();
                bindConditionsForm();
            });

    }

    function bindConditionsFilter() {

        $(".add_condition_filter")
            .unbind("click")
            .bind("click", function () {
                let condName = `${conditionPrefix}${++conditionFilterCounter}`;

                $(this)
                    .before(filter_condition_template_html);

                $(this)
                    .parent()
                    .find("label")
                    .last()
                    .find(".condition_input")
                    .attr("name", condName)
                    .parent()
                    .find(".condition_label")
                    .last()
                    .text(condName);
                bindConditionsFilter();
            });

        $(".delete_condition_filter")
            .unbind("click")
            .bind("click", function () {
                $(this).parent().remove();
                bindConditionsFilter();
            });

    }

    function filterFormSubmit(url) {
        $(filter_form).prop("action", url).submit();
    }

    bindConditionsForm();

    bindConditionsFilter();

    $(".event_manager").show();

    $(".filter_html").bind("click", function () {
        filterFormSubmit(urls.filtered_events.html);
    });
    $(".filter_json").bind("click", function () {
        filterFormSubmit(urls.filtered_events.json);
    });
    $(".priority_as_html").bind("click", function () {
        filterFormSubmit(urls.priority_event.html);
    });
    $(".priority_as_json").bind("click", function () {
        filterFormSubmit(urls.priority_event.json);
    });
});