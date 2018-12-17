<template>
    <div>
        <span v-for="role in roles" class="mx-1">{{ role.display }}</span>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    data: () => ({
        options: []
    }),
    computed: {
        roles() {
            let _this =  this;
            return this.field.options.filter(function(option) {
                return _this.options[option.value] == true
            })
        },
    },
    methods: {

    },
    mounted() {
        this.options = (this.field.value)
            ? JSON.parse(this.field.value)
            : [];

    }
}
</script>
