<template>
    <div color="lighten-2">
        <h3 class="text-h5 lighten-3">Search for Books</h3>
        <div>Explore hundreds of books</div>
        <div>
            <v-autocomplete
                v-model="model"
                :items="items"
                :loading="isLoading"
                :filter="customSearch"
                :search-input.sync="search"
                color="white"
                hide-no-data
                hide-selected
                :item-text="inputField"
                item-value="id"
                placeholder="Start typing to Search"
                prepend-icon="mdi-database-search"
                return-object
            >
                <template v-slot:item="data">
                    <template v-if="typeof data.item !== 'object'">
                        <v-list-item-content
                            v-text="data.item"
                        ></v-list-item-content>
                    </template>
                    <template v-else>
                        <v-list-item-content>
                            <v-list-item-title
                                v-html="data.item.title"
                            ></v-list-item-title>
                            <v-list-item-subtitle
                                v-html="data.item.description"
                            ></v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </template>
            </v-autocomplete>
        </div>
        <v-divider></v-divider>
        <v-expand-transition>
            <div v-if="model">
                <v-card class="p-5 mb-5">
                    <v-list class="lighten-3">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-subtitle
                                    >Title</v-list-item-subtitle
                                >
                                <v-list-item-title
                                    v-text="model.title"
                                ></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-subtitle
                                    >Description</v-list-item-subtitle
                                >
                                <v-list-item-title
                                    v-text="model.description"
                                ></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-subtitle
                                    >Author</v-list-item-subtitle
                                >
                                <v-list-item-title
                                    v-text="model.author"
                                ></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-subtitle
                                    >Libraries</v-list-item-subtitle
                                >
                                <v-list-item-description>
                                    <v-chip
                                        v-for="library in model.libraries"
                                        :key="library.id"
                                        class="ma-2"
                                        color="green"
                                        text-color="white"
                                    >
                                        {{ library.name }}
                                    </v-chip>
                                </v-list-item-description>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                    <v-card-actions>
                        <v-btn
                            @click="thumbupBook(model.id)"
                            :color="model.isLike ? 'yellow' : 'gray'"
                            icon
                            class="mr-4"
                            ><v-icon>mdi-thumb-up</v-icon></v-btn
                        >
                        <v-divider vertical></v-divider>
                        <router-link
                            :to="`/books/edit/${model.id}`"
                            class="ml-4"
                            >Edit Book</router-link
                        >
                    </v-card-actions>
                </v-card>
            </div>
        </v-expand-transition>
        <div>
            <v-spacer></v-spacer>
            <v-btn :disabled="!model" outlined @click="model = null">
                Clear
                <v-icon right> mdi-close-circle </v-icon>
            </v-btn>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        descriptionLimit: 60,
        entries: [],
        isLoading: false,
        model: null,
        search: null,
        inputField: "title",
    }),
    computed: {
        items() {
            const currentUser = window.Laravel.user;
            return this.entries.map((entry) => {
                const description =
                    entry.description.length > this.descriptionLimit
                        ? entry.description.slice(0, this.descriptionLimit) +
                          "..."
                        : entry.description;
                let isLike = false;

                entry.voted_users.map((user) => {
                    if (user.id === currentUser.id) isLike = true;
                });
                return Object.assign({}, entry, { description, isLike });
            });
        },
    },
    methods: {
        customSearch(item, queryText, itemText) {
            const textOne =
                item.title.toLowerCase() + item.description.toLowerCase();
            const searchText = queryText.toLowerCase();

            return textOne.indexOf(searchText) > -1;
        },
        thumbupBook(id) {
            this.$axios.get("/sanctum/csrf-cookie").then((response) => {
                this.$axios
                    .post(`/api/books/${id}/like`, {
                        isLike: !this.model.isLike,
                    })
                    .then((response) => {
                        this.model.isLike = !this.model.isLike;
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
        },
    },

    watch: {
        search(val) {
            // Items have already been loaded
            if (this.items.length > 0) return;

            // Items have already been requested
            if (this.isLoading) return;

            this.isLoading = true;

            // Lazily load input items
            this.$axios.get("/sanctum/csrf-cookie").then((response) => {
                this.$axios
                    .get(`/api/books`)
                    .then((response) => {
                        const { data } = response;
                        console.log(data);
                        this.entries = data;
                    })
                    .catch(function (error) {
                        console.error(error);
                    })
                    .finally(() => (this.isLoading = false));
            });
        },
    },
};
</script>
