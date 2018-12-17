<template>
    <div>
        <div class="flex border-b border-40">
            <div class="w-1/4 py-4">
                <h4 class="font-normal text-80">{{field.name}}</h4>
            </div>
            <div class="w-3/4 py-4"><p><span v-for="role in roles" class="mx-1">{{ role.display }}</span></p></div></div>

    </div>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
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
