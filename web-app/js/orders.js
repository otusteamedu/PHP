$(document).ready(() => {

    let sections = {
        step_wait: $('.step_wait'),
        step_error: $('.step_error'),
        step_success: $('.step_success'),
        client_name: $('.client_name'),
        address: $('.address'),
        products: $('.products'),
        delivery_services: $('.delivery_services'),
        discounts: $('.discounts'),
        total_price: $('.total_price')
    };

    function showResult(order) {
        $(sections.products).html('');
        $(sections.discounts).html('');
        $(sections.delivery_services).html('');
        $(sections.client_name).text(order.client.name);
        $(sections.address).text(order.client.address);
        if (Array.isArray(order.contents.products)) {
            order.contents.products.forEach(product => {
                $(sections.products).append(
                    `<div>${product.title} ..... <em>${product.weight}кг</em> .... <strong>${product.price} у.е.</strong></div>`
                );
            });
        }
        if (Array.isArray(order.contents.deliveryServices)) {
            order.contents.deliveryServices.forEach(deliveryService => {
                $(sections.delivery_services).append(
                    `<div>${deliveryService.name} ..... <strong>${deliveryService.price} у.е.</strong></div>`
                );
            });
        }
        if (Array.isArray(order.contents.discounts)) {
            order.contents.discounts.forEach(discount => {
                if (discount.value) {
                    $(sections.discounts).append(
                        `<div>${discount.label} ..... <strong>${discount.value} у.е.</strong></div>`
                    );
                } else if (discount.percents) {
                    $(sections.discounts).append(
                        `<div>${discount.label} ..... <strong>${discount.percents} %</strong></div>`
                    );
                }
            });
        }
        $(sections.total_price).text(`${order.total_price} у.е.`);
    }

    function checkCalculation(ticketId) {
        let timer = setInterval(function () {
            $.get(`http://localhost:8080/api/orders?ticket_id=${ticketId}`)
                .done(res => {
                    console.log(res);
                    if (res !== false) {
                        clearInterval(timer);
                        $(sections.step_wait).hide();
                        $(sections.step_success).show();
                        showResult(res);
                    }
                })
                .fail(() => {
                    clearInterval(timer);
                    $(sections.step_error).show();
                    $(sections.step_wait).hide();
                });
        }, 2000);
    }

    let form = $('#create_order_form');
    $(form).bind('submit', (e) => {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: e.target.action,
                data: $(e.target).serialize(),
            }).done(res => {
                checkCalculation(res.ticketId);
                $(sections.step_wait).show();
                $(sections.step_success).hide();
                $(sections.step_error).hide();
                console.log(res);
            });
        }
    );
});