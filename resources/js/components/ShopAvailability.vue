<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card p-0">
                <div class="card-header">Shop's Availability</div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td>For Date:</td>
                            <td>
                                <date-picker
                                    @change="getAvailability"
                                    v-model="forDate"
                                    type="datetime"
                                ></date-picker>
                            </td>
                        </tr>
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
import DatePicker from 'vue2-datepicker';

export default {
    components: { DatePicker },
    data() {
        return {
            forDate: new Date(),
            isOpen: false,
            datetime: null,
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    created() {
        this.getAvailability();
    },
    methods: {
        getAvailability() {
            // Not handling field validation errors for now
            this.axios
                .get('/api/is-open-on', { params: { 'date': this.forDate } })
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
