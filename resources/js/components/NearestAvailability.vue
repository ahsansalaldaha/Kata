<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card p-0">
                <div class="card-header">Shop's Nearest Availability</div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td>Shop will next open on:</td>
                            <td>
                                <strong>{{ !open_on ? "Either open already or schedule not known!" : open_on }}</strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            open_on: false,
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    created() {
        this.reload();
    },
    methods: {
        reload() {
            // Not handling field validation errors for now
            this.axios
                .get('/api/nearest-open-date')
                .then(({ data }) => {
                    this.open_on = data.nearest_open;
                }).catch((err) => {
                    console.error(err)
                });

        },
    },
}
</script>

<style scoped>
.p-0 {
    padding: 0;
}
</style>
