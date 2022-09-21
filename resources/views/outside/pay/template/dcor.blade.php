<div class="form-group">
    <label for="agreementNumber">Номер договора</label>
    <input type="text" placeholder="Номер договора" id="agreementNumber"
           class="form-control" name="jsonParam[agreementNumber]" required>
</div>
<div class="form-group">
    <label for="studentName">ФИО обучающегося</label>
    <input type="text" placeholder="ФИО обучающегося" id="studentName" class="form-control"
           name="jsonParam[studentName]" required>
</div>
<div class="form-group">
    <label for="fioPayment">ФИО платильщика</label>
    <input type="text" placeholder="ФИО плательщика" id="fioPayment" class="form-control"
           name="jsonParam[fioPayment]" required>
</div>

<style>
    .cursor-pointer {
        cursor: pointer;
    }
</style>

<script>
    jQuery(document).ready(function ($) {
        class Customer {
            contract = null;
            listener = null;
            phone = null;
            email = null;
            customer = null;

            getContract() {
                return this.contract;
            }

            getEmail() {
                return this.email;
            }

            getPhone() {
                return this.phone;
            }

            getStudent() {
                return this.listener;
            }

            getParent() {
                return this.customer;
            }

            checkListener(val) {
                return this.findMatch(this.listener, val);
            }

            checkCustomer(val) {
                return this.findMatch(this.customer, val);
            }

            findMatch(a, b) {
                return a !== undefined && this.strToLower(a).search(this.strToLower(b)) !== -1;
            }

            strToLower(str) {
                return str.toLowerCase();
            }

            find(contract, callback) {
                let customer = this.getCustomer();

                if (empty(customer.getContract()) || contract !== customer.getContract()) {
                    $.ajax({
                        url: '{{ route('api-dcor') }}',
                        type: 'POST',
                        async: true,
                        data: {contract_number: contract},
                        success: function (res) {
                            if (res) {
                                customer = customer.setCustomer(
                                    res.contract_number,
                                    res.listener_full_name,
                                    res.customer_phone_number,
                                    res.customer_email,
                                    res.customer_full_name);

                                return callback(customer, 200)
                            }
                        },
                        error: function (res) {
                            return callback(null, res.status);
                        }
                    });
                } else if (contract === customer.getContract()) {
                    return callback(customer, 200);
                } else {
                    return callback(new Customer(), 404);
                }
            }

            getCustomer() {
                return this;
            }

            setCustomer(contract, listener, phone, email, customer) {
                this.contract = contract;
                this.listener = listener;
                this.phone = phone;
                this.email = email;
                this.customer = customer;

                return this;
            }
        }

        var customer = new Customer();

        $('form').on({submit: submit});

        $(document).on({
            blur: function () {
                let ths = $(this);
                let contract = ths.val();
                if (contract.length > 2) {
                    customer.find(contract, (res, status) => {
                        let id = ths.attr('id');
                        let s = '#' + id;
                        $('.' + id).remove();

                        if (status !== 200) {
                            customer = new Customer();
                            borderColor(s, 'error');
                            ths.parent().append('<span class="badge bg-danger text-white ' + id + '">Договор не найден</span>');
                        } else {
                            customer = res;
                            borderColor(s, 'success');
                        }
                    });
                }
            }
        }, '#agreementNumber');

        $(document).on({
            keyup: function (e) {
                if (!isStrKey(e)) return;

                let name = $(this).val();
                if (empty(name) || empty(customer.getStudent())) return;

                findData(name, customer.checkListener(name), '#studentName', 'js-student-name', customer.getStudent());
            }
        }, '#studentName');

        $(document).on({
            keyup: function (e) {
                if (!isStrKey(e)) return;

                let custName = $(this).val();
                if (empty(custName) || empty(customer.getParent())) return;

                findData(custName, customer.checkCustomer(custName), '#fioPayment', 'js-customer-name', customer.getParent());
            }
        }, '#fioPayment');

        /* Если условие выполняется, появлется выпадающий список с выбором */
        function findData(val, condition, selector, badgeSelector, property) {
            let result = false;

            borderColor(selector, 'default');
            $('.' + badgeSelector).remove();

            if (val.length > 4) {
                if (condition) {
                    $(selector).parent().append('<span class="badge bg-success text-white cursor-pointer ' + badgeSelector + '">' + property + '</span>');
                    result = true;
                }
            }

            $(document).on({
                click: function () {
                    let text = $(this).text();
                    $(selector).val(text);
                    borderColor(selector, 'success');
                    $(this).remove();
                }
            }, '.' + badgeSelector);

            return result;
        }

        function borderColor(selector, status) {
            if (status === 'success') {
                $(selector).attr('data-has-error', 0).css('border-color', '#28a745');
            } else if (status === 'error') {
                $(selector).attr('data-has-error', 1).css('border-color', '#dc3545');
            } else {
                $(selector).attr('data-has-error', 0).css('border-color', '#ccc');
            }
        }

        function isStrKey(e) {
            return e.which <= 90 && e.which >= 48 || e.which === 8;
        }

        function submit(event) {
            event.preventDefault();

            if (validation())
                this.submit();
        }

        function validation() {
            return !empty(customer.getContract());
        }

        function empty(mixed_var) {
            return (mixed_var === "" || mixed_var === 0 || mixed_var === "0" || mixed_var === null || mixed_var === false);
        }

    });// end ready
</script>
