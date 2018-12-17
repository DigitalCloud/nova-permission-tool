<template>
    <default-field :field="field">
        <template slot="field">
            <div class="flex flex-wrap content-start " >
                <div v-for="group in availableGroups" class="flex items-center w-1/3">
                    <fieldset class="w-full p-2 m-1">
                        <legend class="mx-1 px-1">
                            <div class="flex">
                                <checkbox
                                    class=""
                                    @input="selectAllGroupedOptions(group.options)"
                                    :id="group.name"
                                    :name="group.name"
                                    :checked="isAllGroupedOptionsSelected(group.options)"
                                >&nbsp;</checkbox>
                                <h4>{{group.name}}</h4>
                            </div>

                        </legend>

                        <div v-for="option in group.options" @click="handleChange(option.value)" class="flex ">
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
                    </fieldset>
                </div>
            </div>
        </template>
    </default-field>
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
        availableGroups() {
            var groups = {}
            this.field.options.forEach(option => {
                if (groups[option.resource]) {
                    groups[option.resource].options.push(option)
                }
                else {
                    groups[option.resource] = {name: option.resource, options: [option]}
                }
            })
            return _.toArray(groups)

        },
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

        isAllGroupedOptionsSelected(options){
            let _this = this;
            let result = true;
            _.each(options, function(option) {
                if(_this.options[option.value] == false) {
                    result = false;
                    return false;
                }
            });
            return result;
        },
        selectAllGroupedOptions(options) {
            let _this = this;
            if(this.isAllGroupedOptionsSelected(options)) {
                _.each(options, function(option) {
                    _this.options[option.value] = false;
                });
                return;
            }
            _.each(options, function(option) {
                _this.options[option.value] = true;
            });
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

<style>
    fieldset {
        border: 1px groove;
    }
</style>
