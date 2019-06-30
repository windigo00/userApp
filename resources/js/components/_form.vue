<script>
    /**
     * This is base template for login and reg forms
     *
     *
     */
    export default {

        data()
        {
            return {};
        },

        methods: {
            validateAction() { return true; },
            submitAction() {}
        },

        mounted()
        {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var form = this.$el.getElementsByClassName('form-signin')[0];
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                event.stopPropagation();
                if (this.validateAction() && form.checkValidity() !== false) {
                    form.classList.add('was-validated');
                    this.submitAction();
                }
            }.bind(this), false);

        }
    }
</script>

<style>
    html,
    body {
        height: 100%;
    }

    body {
/*        display: -ms-flexbox;
        display: flex;*/
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin .btn {
        position: relative;
    }
    .form-signin .fa-pull-right {
        vertical-align: middle;
        position: absolute;
        right: 14px;
        top: 14px;
    }

    .form-signin {
        max-width: 330px;
        width: 100%;
        margin: auto;
        padding: 15px;
    }

    .form-signin .checkbox {
        font-weight: 400;
    }

    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input.other {
        margin-bottom: -1px;
        border-radius: 0;
    }
    .form-signin input.first {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input.last {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .divider-text {
        position: relative;
        text-align: center;
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .divider-text span {
        padding: 7px;
        font-size: 12px;
        position: relative;
        z-index: 2;
    }
    .divider-text:after {
        content: "";
        position: absolute;
        width: 100%;
        border-bottom: 1px solid #ddd;
        top: 55%;
        left: 0;
        z-index: 1;
    }

</style>

