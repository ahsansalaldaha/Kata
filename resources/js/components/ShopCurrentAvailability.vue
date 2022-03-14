<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card p-0">
                <div class="card-header">
                    Shop's Current Availability
                    <button
                        class="btn btn-primary btn-outline btn-sm"
                        @click="reload"
                    >Reload</button>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td>Shop is:</td>
                            <td>
                                <div
                                    :class="`badge badge-availability bg-${isOpen ? 'success' : 'danger'}`"
                                >{{ isOpen ? 'Open' : 'Closed' }}</div>
                                <small>{{ datetime | moment("calendar") }}</small>
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
            isOpen: false,
            datetime: null,
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
                .get('/api/is-open-now')
                .then(({ data }) => {
                    this.isOpen = data.is_open;
                    this.datetime = this.$moment(data.datetime).local();
                }).catch((err) => {
                    console.error(err)
                });

        },
    },
}
</script>

<style scoped>
.badge-availability {
    font-size: 16px;
}
.p-0 {
    padding: 0;
}
</style>
