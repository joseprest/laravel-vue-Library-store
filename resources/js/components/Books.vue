<template>
    <div>
        <h4 class="text-center">All Books</h4>
        <br />
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="book in books" :key="book.id">
                    <td>{{ book.id }}</td>
                    <td>
                        <router-link :to="`book/${book.id}`">{{
                            book.title
                        }}</router-link>
                    </td>
                    <td>{{ book.author }}</td>
                    <td>{{ book.created_at }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <router-link
                                :to="{
                                    name: 'editbook',
                                    params: { id: book.id },
                                }"
                                class="btn btn-primary"
                                >Edit
                            </router-link>
                            <button
                                class="btn btn-danger"
                                @click="deleteBook(book.id)"
                            >
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <v-btn
            class="ma-2"
            outlined
            color="indigo"
            @click="$router.push('/books/add')"
        >
            Add Book
        </v-btn>
    </div>
</template>

<script>
export default {
    data() {
        return {
            books: [],
        };
    },
    created() {
        this.$axios.get("/sanctum/csrf-cookie").then((response) => {
            this.$axios
                .get("/api/books")
                .then((response) => {
                    this.books = response.data.map((book) => {
                        return {
                            ...book,
                            created_at: new Date(book.created_at).toISOString(),
                        };
                    });
                })
                .catch(function (error) {
                    console.error(error);
                });
        });
    },
    methods: {
        deleteBook(id) {
            this.$axios.get("/sanctum/csrf-cookie").then((response) => {
                this.$axios
                    .delete(`/api/books/delete/${id}`)
                    .then((response) => {
                        let i = this.books.map((item) => item.id).indexOf(id); // find index of your object
                        this.books.splice(i, 1);
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
        },
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    },
};
</script>
