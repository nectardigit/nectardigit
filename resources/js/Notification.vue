<template>
    <div class="chat__box">
        <div class="chat__initiate" v-if="!isInitiated">
            <form action="" @submit.prevent="StartConversation()">
                <label for="name">Your Name </label>
                <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model.trim="name"
                />
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    class="form-control"
                    v-model.trim="email"
                />
                <label for="phone"> Phone No.</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="form-control form-control-sm"
                    v-model.trim="phone"
                />
                <label for="message">Message</label>
                <textarea
                    name="message"
                    id="message"
                    rows="2"
                    class="form-control"
                    v-model.trim="message"
                >
 
Write your query here..</textarea
                >
                <button class="btn btn-primary mt-2">Start Conversation</button>
            </form>
        </div>
        <div v-if="isInitiated">
            <div class="chat__header">
                <h1 class="flex__box">Chat</h1>
                <div class="settings flex__box">
                    <i class="fa fa-close"></i>
                </div>
            </div>
            <div class="chat__body" @scroll="loadMoreMessage">
                <ul>
                    <li
                        v-for="message in message_list"
                        :key="message.id"
                        :class="
                            message.by_system == 'yes'
                                ? 'incoming_message'
                                : 'outgoing_message'
                        "
                    >
                        <div class="message__flex">
                            <div class="avatar">
                                <img
                                    
                                    src="images/user.png"
                                    alt="Admin"
                                />
                            </div>
                            <div class="message__wrapper">
                                <div class="message_text">
                                    <p>
                                        {{ message.message }}
                                    </p>
                                </div>
                                <div class="message__time">
                                    {{ message.messaged_at }}
                                </div>
                            </div>
                            
                        </div>
                    </li>
                </ul>
            </div>
            <div class="chat__footer">
                <p v-if="isTyping">
                    <small>is typing..</small>
                </p>
                <form @submit.prevent="SendMessage()" action="" method="post">
                    <textarea
                        name=""
                        id=""
                        rows="2"
                        class="message__area"
                        v-model.trim="message"
                    ></textarea>
                    <!-- <input type="file" /> -->
                    <button class="btn btn-info btn-sm">send</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
 
export default {
    props: ["app", "conversationUrl"],
    mounted() {
        // console.log(this.conversationUrl);
        this.startChannel();
        this.fetchOldMessages();
    },
    data() {
        return {
            isInitiated: false,
            message_list: "",
            isTyping: false,
            message: "",
            name: "",
            email: "",
            phone: "",
            conversation_id: ""
        };
    },
    methods: {
        fetchOldMessages() {
            var id = localStorage.getItem("c_id");
            if (id) {
                this.isInitiated = true;
                const data = {
                    getMessages: this.conversationUrl.getMessages,
                    id: id
                };
                Request.getMessage(data).then(response => {
                    if (response.success) {
                        this.message_list = response.message_data.messages_list;
                        this.startChannel();
                        this.scrollToBottom();
                    }
                });
            }
        },
        StartConversation(event) {
            const Conversationdata = {
                name: this.name,
                email: this.email,
                phone: this.phone,
                message: this.message,
                startConversation: this.conversationUrl.startConversation
            };
            Request.StartConversation(Conversationdata).then(response => {
                console.log(response);
                if (response.success) {
                    this.message = "";
                    this.isInitiated = true;
                    this.conversation_id = Conversationdata.id;
                    this.message_list = response.messages_list;
                    this.startChannel();
                    // alert(response.message);
                }
            });
            console.log("data is ", Conversationdata);
        },
        SendMessage(event) {
            let message = this.message;

            if (!message) {
                // alert("Message is required");
                return false;
            } else {
                const messageData = {
                    message: message,
                    conversation_id: localStorage.getItem("c_id"),
                    messageUrl: this.conversationUrl.message_url
                };
                Request.sendMessage(messageData).then(response => {
                    this.message = "";
                    this.scrollToBottom();
                    this.message_list.push(response.message_data);
                });
            }
        },
        scrollToBottom() {
            var container = document.querySelector(".chat__body");
            // var heights = document.querySelector(".chats");
            // container.scrollTop = container.scrollHeight + 3000;
            $(".chat__body").animate(
                {
                    scrollTop: 20000000
                },
                50
            );
        },
        startChannel() {
            var socket = io(window.location.hostname + ":" + 6001);
            socket.emit("new-user", "hello from client");
            socket.on("hello", function(data) {
                console.log(data);
            });
            socket.on(
                "AdminOnline",
                function(data) {
                    // this.is_online = data.admin.name;
                }.bind(this)
            );
            // socket.on('isTyping').listen(".SocketEvent", data => {
            //     console.log("daata are ", data);
            // });

            //socket.emit(user_channel, "hello from client");
            //
            // this.conversation_id = localStorage.getItem("c_id");
            // var user_channel = "user-channel-" + this.conversation_id;
            // this.$echo.channel(user_channel).listen(".SocketEvent", data => {
            //     // alert("hello");
            //     if (data && data.message) {
            //         // console.log("event data are ", data);
            //         // console.log("cid ", this.conversation_id);
            //         this.message_list.push(data.message);
            //     }
            // });
        },
        loadMoreMessage() {
            $(window).scrollTop() + $(window).height() == $(document).height();
        }
    }
};
</script>
