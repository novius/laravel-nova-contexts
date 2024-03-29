<template>
    <Card class="flex flex-col flex-wrap">
        <div class="flex p-4" v-if="contexts.length > 2">
            <div class="font-bold text-90 mr-2">
                {{ __('context') }}
            </div>
            <ul

                    class="flex list-reset context-list"
            >
                <context
                        v-for="(item, index) in contexts"
                        v-bind:item="item"
                        v-bind:index="index"
                        v-bind:key="item.id"
                        v-bind:publicName="item.public_name"
                        v-bind:contextKey="item.context_key"
                        v-bind:isCurrent="item.current"
                        @selected-context="selectedContext($event)"
                ></context>
            </ul>
        </div>
    </Card>
</template>

<script>
import Context from './Context'
import { Localization } from 'laravel-nova'

export default {

    mixins: [Localization],

    components: {
        Context
    },

    props: [
        'card',
    ],

    data: () => ({
        contexts: [],
    }),

    methods: {

        getContexts() {
            Nova.request({
                url: '/nova-vendor/laravel-nova-contexts/list-contexts',
                method: 'GET',
            }).then(({ data }) => {
                if (data.error) {
                    Nova.error(data.message);
                } else {
                    this.contexts = data.contexts;
                }
            });
        },

        selectedContext(event) {
            const indexSelected = event[0];
            const contextKey = event[1];

            let freshContexts = [];
            this.contexts.forEach((context, index) => {
                if (index !== indexSelected) {
                    context['current'] = false;
                } else {
                    context['current'] = true;
                }

                freshContexts.push(context);
            });

            this.contexts = freshContexts;

            this.saveCurrentContext(contextKey);
        },

        saveCurrentContext(contextKey) {
            Nova.request({
                url: '/nova-vendor/laravel-nova-contexts/update-current-context',
                method: 'POST',
                params: {
                    context: contextKey
                },
            }).then(({ data }) => {
                if (data.error) {
                    Nova.error(data.message);
                } else {
                    Nova.$toasted.show(data.message, {
                        action: {
                            onClick: () => location.reload(),
                            text: this.__('reloadPage'),
                        },
                        type: 'success',
                    })

                }
            });
        }

    },

    created() {
        this.getContexts()
    },
}
</script>
