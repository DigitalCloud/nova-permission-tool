<template>
    <default-field :field="field">
        <template slot="field">
            <div class="flex flex-wrap content-start -mx-1 mb-1" >
                <div v-for="option in field.options" @click="handleChange(option.value)" class="flex items-center w-1/3">
                    <checkbox
                    class="py-2 mr-4"
                    :id="field.name"
                    :name="field.name"
                    :checked="options[option.value]"
                    ></checkbox>
                    <label
                    :for="field.name"
                    v-text="option.display"

                    ></label>
                </div>
            </div>
        </template>
    </default-field>
    <!--<default-field :field="field">-->
        <!--<template slot="field">-->
            <!--<ul class="list-reset" >-->
                <!--<li class="flex items-center" v-for="option in field.options">-->
                    <!--<checkbox-->
                        <!--class="py-2 mr-4"-->
                        <!--@input="handleChange(option.value)"-->
                        <!--:id="field.name"-->
                        <!--:name="field.name"-->
                        <!--:checked="options[option.value]"-->
                    <!--&gt;</checkbox>-->
                    <!--<label-->
                        <!--:for="field.name"-->
                        <!--v-text="option.display"-->
                        <!--@click="handleChange(option.value)"-->
                    <!--&gt;</label>-->
                <!--</li>-->
            <!--</ul>-->
        <!--</template>-->
    <!--</default-field>-->
</template>

<script>
import { FormField, HandlesValidationErrors, Minimum } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data: () => ({
        options: []
    }),

    computed: {
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || '';
            this.$nextTick(() => {
                this.options = (this.value)
                    ? JSON.parse(this.value)
                    : [];
            });
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(key) {
            this.options[key] = ! this.options[key];
        },
    },
    watch: {
        'options' : {
            handler: function (newOptions) {
                this.value = JSON.stringify(newOptions);
            },
            deep: true
        }
    }
}
</script>
