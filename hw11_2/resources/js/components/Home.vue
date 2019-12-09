import swal from "sweetalert2";
<script>
    export default {
        methods: {
            showConfirmation() {
                this.$swal({
                    title: 'Clear all events?',
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    focusCancel: true
                }).then((result) => {
                    if (result.value) {
                        this.$refs.clearForm.submit()
                    }
                })
            }
        }
    }
</script>
