<template>
    <div>
        Detail of Library

        <v-data-table
            :headers="headers"
            :items="books"
            :items-per-page="5"
            class="elevation-1"
        ></v-data-table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            headers: [
                {
                    text: "Title",
                    align: "start",
                    sortable: false,
                    value: "title",
                },
                { text: "Author", value: "author" },
                { text: "Description", value: "description" },
                { text: "Created", value: "created_at" },
            ],
            books: [],
        };
    },
    created() {
        const libraryId = this.$route.params.id;
        this.$axios.get("/sanctum/csrf-cookie").then((response) => {
            this.$axios
                .get(`/api/libraries/edit/${libraryId}`)
                .then((response) => {
                    this.books = response.data.books.map((book) => {
                        return {
                            ...book,
                            description:
                                book.description.substring(0, 30) + "...",
                        };
                    });
                })
                .catch(function (error) {
                    console.error(error);
                });
        });
    },
};
</script>
