    <!-- Start Footer  -->
    <footer>
        <div class="footer-main">
            <div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Business Time</h3>
							<ul class="list-time">
								<li>Monday - Friday: 08.00am to 05.00pm</li> <li>Saturday: 10.00am to 08.00pm</li> <li>Sunday: <span>Closed</span></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Newsletter</h3>
							<form class="newsletter-box">
								<div class="form-group">
									<input class="" type="email" name="Email" placeholder="Email Address*" />
									<i class="fa fa-envelope"></i>
								</div>
								<button class="btn hvr-hover" type="submit">Submit</button>
							</form>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Social Media</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<ul>
                                <li><a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-google-plus" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                            </ul>
						</div>
					</div>
				</div>
				<hr>
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-widget">
                            <h4>About Freshshop</h4>
                            <p>At Groupon Produce, we believe in bridging the gap between farmers and consumers through a seamless, direct-to-source marketplace. Our cross-platform application, designed for Windows desktops, empowers farmers to showcase their fresh produce, manage orders efficiently, and track inventory—all in one place.</p> 
												
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link">
                            <h4>Information</h4>
                            <ul>
                                <li><a href="<?php echo base_url(); ?>about">About Us</a></li>
                                <li><a href="<?php echo base_url(); ?>shop">Shop</a></li>
                                <li><a href="<?php echo base_url(); ?>contact">Contact</a></li>
                              
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link-contact">
                            <h4>Contact Us</h4>
                            <ul>
                                <li>
                                    <p><i class="fas fa-map-marker-alt"></i>Address: Michael I. Days 3756 <br>Preston Street Wichita,<br> KS 67213 </p>
                                </li>
                                <li>
                                    <p><i class="fas fa-phone-square"></i>Phone: <a href="tel:+1-888705770">+1-888 705 770</a></p>
                                </li>
                                <li>
                                    <p><i class="fas fa-envelope"></i>Email: <a href="mailto:contactinfo@gmail.com">contactinfo@gmail.com</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer  -->

    <!-- Start copyright  -->
    <div class="footer-copyright">
        <p class="footer-company">All Rights Reserved. &copy; 2025 <a href="#">Groupon Produce</a></p>
    </div>

 <?php if(!empty($this->session->userdata('user_id'))){ ?>

               

<div id="chatFloatingBtn" class="chat-floating-btn">
  Chat
  <span id="floatingUnreadBadge" class="floating-unread-badge" style="display: none;">0</span>
</div>


<!-- Chat Window -->
<div id="chatWindow" class="chat-window" style="display: none;">
  <div class="chat-header">
    <span id="selectedUserName">Select User to Chat</span>
    <button id="closeChatBtn" class="close-btn">&times;</button>
  </div>

  <!-- Main content with two panels: left user list, right messages -->
  <div class="chat-content">
    <!-- Left Panel: user list -->
   <div class="chat-user-panel">
      <input type="text" id="searchUser" placeholder="Search users..." class="search-box">
      <div class="chat-user-list" id="chatUserList">
        <!-- Users will be dynamically added here -->
      </div>
    </div>

    <!-- Right Panel: chat messages -->
    <div class="chat-messages-panel">
      <div class="chat-messages" id="chatMessages"></div>
      <div class="chat-input">
        <input type="text" id="chatMessageInput" placeholder="Type a message..." disabled />
        <button id="sendChatBtn" type="submit" disabled>Send</button>
      </div>
    </div>
  </div>
</div>

<!-- Chat Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  let selectedUserId = null; // The user we are chatting with
  let isSearching = false;

  // Show the chat window
  document.getElementById('chatFloatingBtn').addEventListener('click', function() {
    document.getElementById('chatWindow').style.display = 'block';
    loadUserList();
  });

  // Hide the chat window
  document.getElementById('closeChatBtn').addEventListener('click', function() {
    document.getElementById('chatWindow').style.display = 'none';
  });

  
  document.getElementById('sendChatBtn').addEventListener('click', function() {
    sendChatMessage();
});


$("#chatMessageInput").on("keypress", function(e) {
    if (e.which === 13) {  // 13 is the Enter key
        e.preventDefault(); // Prevents newline if needed
        sendChatMessage();
    }
});

function sendChatMessage() {
    const message = $("#chatMessageInput").val().trim();
    if (!message || !selectedUserId) return;

    // TODO: integrate with your chat endpoint
    // e.g. sendMessage(selectedUserId, message)
    // then refetch messages
    sendMessage(selectedUserId, message);

    $("#chatMessageInput").val("");
}
let allUsers = []; // global variable
  // Example: fetch user list (farmers or customers)
 function loadUserList() {
    $.ajax({
        url: "<?= base_url('chat/fetch_users'); ?>",  
        type: "GET",
        dataType: "json",
        success: function(users) {
             allUsers = users;
            renderUserList(allUsers);
            // Attach event listener to the search input
           
        },
        error: function(xhr, status, error) {
            console.error("Error fetching user list:", error);
        }
    });
}


// Function to render the user list dynamically
function renderUserList(users) {
  // Sort users by unread_count first, then by last_message_time
  users.sort((a, b) => {
    if (b.unread_count !== a.unread_count) {
      return b.unread_count - a.unread_count;
    }
    const timeA = a.last_message_time ? new Date(a.last_message_time).getTime() : 0;
    const timeB = b.last_message_time ? new Date(b.last_message_time).getTime() : 0;
    return timeB - timeA; // latest first
  });

  let userListHtml = "";
  let totalUnread = 0;

  users.forEach(u => {
    let fullName = u.first_name + " " + u.last_name;
    totalUnread += u.unread_count;

    let badge = (u.unread_count > 0)
      ? `<span class="unread-badge">${u.unread_count}</span>`
      : '';

    userListHtml += `
      <div class="chat-user-item" data-id="${u.id}" data-name="${fullName}">
        ${fullName} ${badge}
      </div>
    `;
  });

  $("#chatUserList").html(userListHtml);

  // Update floating unread badge
  let floatingBadge = document.getElementById('floatingUnreadBadge');
  if (totalUnread > 0) {
    floatingBadge.textContent = totalUnread > 99 ? '99+' : totalUnread;
    floatingBadge.style.display = 'inline-block';
  } else {
    floatingBadge.style.display = 'none';
  }
}


function updateUserList() {
    if (isSearching) return; // skip updating list during search

    $.ajax({
        url: "<?= base_url('chat/fetch_users'); ?>",  
        type: "GET",
        dataType: "json",
        success: function(users) {
            allUsers = users;
            renderUserList(allUsers);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching user list:", error);
        }
    });
}

$("#searchUser").on("keyup", function () {
    let searchText = $(this).val().toLowerCase();

    if (searchText.length > 0) {
        isSearching = true;
    } else {
        isSearching = false;
        renderUserList(allUsers); // restore full list when input is cleared
        return;
    }

    let filteredUsers = allUsers.filter(u => 
        (u.first_name + " " + u.last_name).toLowerCase().includes(searchText)
    );
    renderUserList(filteredUsers);
});

// Run the function every second to update user list with new messages count
setInterval(updateUserList, 1000);
//setInterval(fetchMessages, 1000);

  // Listen for user clicks on the user list
  $(document).on("click", ".chat-user-item", function() {
    selectedUserId = $(this).data("id");
    let selectedUserName = $(this).data("name"); 

    // Enable message input
    $("#chatMessageInput").prop("disabled", false);
    $("#sendChatBtn").prop("disabled", false);
  $("#selectedUserName").text(selectedUserName);
      $("#chatMessages").html(""); // Clear previous messages before loading new ones
    lastMessageId = null; // Reset message tracking

    // Load messages with selected user
    fetchMessages(selectedUserId);
  });
  var currentUserId = "<?= $this->session->userdata('user_id') 
        ? $this->session->userdata('user_id') 
        : 'null'; ?>";  // Example: fetch messages for selected user
let lastMessageId = null; // Track the last loaded message ID

function fetchMessages(userId) {
   //  lastMessageId = null; // Reset last message ID when switching users
   // $("#chatMessages").html(""); // Clear old messages

    $.ajax({
        url: "<?= base_url('chat/fetch_messages'); ?>",
        type: "POST",
        dataType: "json",
        data: { otherUserId: userId },
        success: function(messages) {
            if (messages.length === 0) return;

            let chatBox = $("#chatMessages");
            let isScrolledToBottom = chatBox.scrollTop() + chatBox.innerHeight() >= chatBox[0].scrollHeight;

            messages.forEach(msg => {
                if (msg.id > lastMessageId) { // Only append new messages
                    let fromId = msg.from_user_id;
                    let isMe = fromId == currentUserId;
                    let senderName = isMe ? "Me" : msg.first_name + " " + msg.last_name;
                    let alignmentClass = isMe ? "message-sent" : "message-received";

                    let msgHtml = `
                        <div class="chat-message ${alignmentClass}" data-msg-id="${msg.id}">
                            <span class="chat-who">${senderName}:</span>
                            <span class="chat-text">${msg.message}</span>
                            <span class="chat-time">(${msg.created_at})</span>
                        </div>
                    `;

                    chatBox.append(msgHtml);
                    lastMessageId = msg.id; // Update last message ID

                    
                }
            });

            // Auto-scroll only if user was at the bottom
            if (isScrolledToBottom) {
                chatBox.scrollTop(chatBox[0].scrollHeight);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching messages:", error);
        }
    });
}

function moveUserToTop(userId, userName) {
    let userItem = $(".chat-user-item[data-id='" + userId + "']");

    // If the user exists in the list, move it to the top
    if (userItem.length) {
        $("#chatUserList").prepend(userItem);
    } else {
        // If user is not in the list, add them dynamically (optional)
        let newUserHtml = `<div class="chat-user-item" data-id="${userId}" data-name="${userName}">${userName}</div>`;
        $("#chatUserList").prepend(newUserHtml);
    }
}


function autoRefreshMessages() {
    if (selectedUserId) { // Ensure a user is selected
        fetchMessages(selectedUserId);
    }
}

// Refresh messages every 1 second
setInterval(autoRefreshMessages, 1000);

  // Example: send message function
  function sendMessage(userId, message) {
  $.ajax({
    url: "<?= base_url('chat/send_message'); ?>",  // your endpoint
    type: "POST",
    dataType: "json",
    data: {
      otherUserId: userId,
      message: message
    },
    success: function(response) {
      if (response.status === 'success') {
        // After sending, refetch messages
        fetchMessages(userId);
      } else {
        console.error("Error sending message:", response.error);
      }
    },
    error: function(xhr, status, error) {
      console.error("AJAX error sending message:", error);
    }
  });
}

</script>
<?php } else {}?>
<style>
    .unread-badge {
  background: red;
  color: white;
  padding: 2px 6px;
  border-radius: 50%;
  margin-left: 5px;
  font-size: 0.8em;
}

  /* Floating Button */
  .chat-floating-btn {
    position: fixed;
    bottom: 20px;
    right: 80px;
    background-color: #007bff;
    color: #fff;
    padding: 14px 16px;
    border-radius: 50%;
    font-weight: bold;
    font-size: 16px;
    text-align: center;
    cursor: pointer;
    z-index: 9999;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
  }
/*.chat-floating-btn {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #25D366; 
  color: white;
  padding: 12px 20px;
  border-radius: 50px;
  font-weight: bold;
  font-size: 16px;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  z-index: 1000;
}
*/
.floating-unread-badge {
  position: absolute;
  top: -6px;
  right: -6px;
  background-color: red;
  color: white;
  font-size: 12px;
  min-width: 18px;
  height: 18px;
  line-height: 18px;
  padding: 0 6px;
  border-radius: 50%;
  text-align: center;
  font-weight: bold;
  box-shadow: 0 0 0 2px white; /* Like WhatsApp badge outline */
  z-index: 1001;
  transition: all 0.3s ease;
}
  /* Chat Window */
  .chat-window {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 500px;
    height: 400px;
    background: #fff;
    border: 1px solid #ccc;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
  }

  .chat-header {
    background: #007bff;
    color: #fff;
    padding: 10px;
    font-size: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .close-btn {
    background: transparent;
    border: none;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
  }

  .chat-content {
    flex: 1;
    display: flex;
  }

  /* Left panel: user list */
  .chat-user-list {
    width: 150px;
    border-right: 1px solid #ccc;
    overflow-y: auto;
    padding: 10px;
    height: 300px;
  }
  .chat-user-item {
    padding: 8px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
  }
  .chat-user-item:hover {
    background: #f0f0f0;
  }

  /* Right panel: messages */
  .chat-messages-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    height:340px;
    overflow:auto;
  }
  .chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 10px;
    background: #fafafa;
  }
  .chat-message {
    margin-bottom: 6px;
  }
  .chat-who {
    font-weight: bold;
    margin-right: 5px;
  }
  .chat-time {
    margin-left: 5px;
    color: #999;
    font-size: 0.8em;
  }
  .chat-input {
    display: flex;
    padding: 10px;
    background: #eee;
  }
  #chatMessageInput {
    flex: 1;
    padding: 5px;
    margin-right: 5px;
  }
  #sendChatBtn {
    padding: 6px 12px;
    background: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
  }
  #sendChatBtn:hover {
    background: #0056b3;
  }

  .chat-message {
    display: flex;
    flex-direction: column;
    max-width: 70%;
    padding: 8px 12px;
    margin: 8px;
    border-radius: 10px;
    font-size: 14px;
    word-wrap: break-word;
}

/* Sent messages (Me) - Align to right */
.message-sent {
    align-self: flex-end;  /* Aligns right */
    background-color: #dcf8c6; /* Light green */
    text-align: right;
    margin-left: auto; /* Pushes it to the right */
    border-top-right-radius: 0;
}

/* Received messages (Other user) - Align to left */
.message-received {
    align-self: flex-start;  /* Aligns left */
    background-color: #f1f1f1; /* Light gray */
    text-align: left;
    margin-right: auto; /* Pushes it to the left */
    border-top-left-radius: 0;
}

/* User name in the message */
.chat-who {
    font-weight: bold;
    font-size: 12px;
    margin-bottom: 2px;
}

/* Timestamp styling */
.chat-time {
    font-size: 10px;
    color: gray;
    margin-top: 4px;
    align-self: flex-end;
}


</style>

    <!-- End copyright  -->

    <a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>

    <!-- ALL JS FILES -->
    <script src="<?php echo base_url() ?>assets/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
    <script src="<?php echo base_url() ?>assets/js/jquery.superslides.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap-select.js"></script>
    <script src="<?php echo base_url() ?>assets/js/inewsticker.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootsnav.js"></script>
    <script src="<?php echo base_url() ?>assets/js/images-loded.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/isotope.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/baguetteBox.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/form-validator.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/contact-form-script.js"></script>
    <script src="<?php echo base_url() ?>assets/js/custom.js"></script>
     <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>        <script>

    $(document).ready(function () {

       function recalcCart() {
        var subTotal = 0;
        
        // Loop through each product row in the table body
        $("#cart_table tbody tr").each(function () {
            // Get quantity and price
            var qty = parseInt($(this).find("input.qty").val());
            var priceText = $(this).find(".price-pr").text();
            // Remove currency symbols and commas (assuming $ symbol)
            var price = parseFloat(priceText.replace(/[$,]/g, ''));
            
            if (!isNaN(qty) && !isNaN(price)) {
                var rowSubtotal = qty * price;
                // Update the subtotal for this row
                $(this).find(".total-pr").text("$" + rowSubtotal.toFixed(2));
                subTotal += rowSubtotal;
            }
        });
        
        // Update the overall order summary
        $("#order_subtotal").text("$" + subTotal.toFixed(2));
        
        // For this example, let's assume tax is calculated as 10% of the subtotal
        var tax = subTotal * 0.10;
        $("#order_tax").text("$" + tax.toFixed(2));
        
        // Grand total = subtotal + tax (shipping is free)
        var grandTotal = subTotal + tax;
        $("#order_grand_total").text("$" + grandTotal.toFixed(2));
    }
    
    // Attach an event listener to the quantity inputs
    $(document).on("input", "input.qty", function () {
        recalcCart();
         var $row = $(this).closest("tr");
        var itemId = $row.data("id");
       
        var newQuantity = parseInt($(this).val());
        
        // Optionally, validate newQuantity (e.g., ensure it's at least 1)
        if(newQuantity < 1) {
            $(this).val(1);
            newQuantity = 1;
        }
        
        // Update the cart item on the server side
        updateCartItem(itemId, newQuantity);
    });
    

    function updateCartItem(itemId, newQuantity) {

       
        $.ajax({
            url: "<?= base_url('cart/updateQuantity'); ?>",
            type: "POST",
            data: { id: itemId, quantity: newQuantity },
            dataType: "json",
            success: function (response) {
                if(response.status === "success") {
                   // toastr.success(response.message);
                    recalcCart();
                } else {
                    toastr.error("Error updating cart item");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error, xhr.responseText);
                toastr.error("Error updating cart item");
            }
        });
    }

    // Function to load cart items and update the order summary
    function loadCartItems() {
        $.ajax({
            url: "<?= base_url('cart/getCartitems'); ?>",
            type: "GET",
            dataType: "json",
            success: function (response) {
                // If response is an object, convert to array
                if (!Array.isArray(response)) {
                    response = Object.values(response);
                }
                
                var cartList = $("#cart_list");
                cartList.empty(); // Clear existing items
                
                var totalPrice = 0;
                if (response.length === 0) {
                    cartList.append("<p>No items in the cart.</p>");
                } else {
                    $.each(response, function (index, item) {
                        // Calculate subtotal for the item
                        var itemSubtotal = parseFloat(item.price) * parseInt(item.quantity);
                        totalPrice += itemSubtotal;
                        
                        // Create cart item HTML with a remove button
                        var cartItemHtml = `
                            <li data-id="${item.id}" style="border-bottom:1px solid #ddd; padding:10px 0;">
                                <a href="#" class="photo">
                                    <img src="<?= base_url() ?>${item.image}" class="cart-thumb" alt="${item.name}" style="width:50px; height:50px;" />
                                </a>
                                <h6><a href="#">${item.name}</a></h6>
                                <p>${item.quantity}x - <span class="price">$${itemSubtotal.toFixed(2)}</span></p>
                                <button class="btn btn-danger btn-xs remove-item" data-id="${item.id}">Remove</button>
                            </li>`;
                        
                        cartList.append(cartItemHtml);
                    });
                    
                    // Append total price item (if needed)
                    var cartTotalHtml = `
                        <li class="total" style="padding-top:10px;">
                            <a href="<?= base_url('cart/view'); ?>" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
                            <span class="pull-right"><strong>Total</strong>: $${totalPrice.toFixed(2)}</span>
                        </li>`;
                    cartList.append(cartTotalHtml);
                }
                
                // Update the order summary section
                updateOrderSummary(totalPrice);
            },
            error: function (xhr, status, error) {
                console.error("Failed to load cart items:", error, xhr.responseText);
            }
        });
    }
    
    // Function to update order summary values
    function updateOrderSummary(subtotal) {
        // Example fixed values (in a real scenario, these may come from your backend or be calculated dynamically)
        var discount = 40;        // fixed discount value
        var couponDiscount = 10;  // fixed coupon discount
        var tax = subtotal * 0.10;              // fixed tax amount
        var shippingCost = 0;     // Free shipping
        
        // Calculate grand total (subtotal - discount - couponDiscount + tax + shippingCost)
        var grandTotal = subtotal  + tax + shippingCost;
        
        // Update the order summary fields
        $("#order_subtotal").text("$" + subtotal.toFixed(2));
       // $("#order_discount").text("$" + discount.toFixed(2));
       // $("#order_coupon").text("$" + couponDiscount.toFixed(2));
        $("#order_tax").text("$" + tax.toFixed(2));
        $("#order_shipping").text("Free");
        $("#order_grand_total").text("$" + grandTotal.toFixed(2));
    }
    
    // Remove item from cart
    $(document).on("click", ".remove-item", function () {
        var itemId = $(this).data("id");
        
        $.ajax({
            url: "<?= base_url('cart/removeItem'); ?>",
            type: "POST",
            data: { id: itemId },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    toastr.success(response.message);
                    // Reload cart items after removal
                    loadCartItems();
                    location.reload();
                } else {
                    toastr.error("Failed to remove item.");
                }
            },
            error: function (xhr, status, error) {
                toastr.error("An error occurred while removing the item.");
                console.error("AJAX Error:", error, xhr.responseText);
            }
        });
    });
    
    // Initial load of cart items and summary
    loadCartItems();
});


$(document).ready(function(){
         $("#side-menu").click(function () {
         let cartList = $("#cart_list");
         cartList.empty(); // Clear existing cart items
 $.ajax({
    url: "<?= base_url('cart/getCartitems'); ?>",
    type: "GET",
    dataType: "json",
    success: function (cartItems) {
        console.log("Cart Items Response:", cartItems); // Debugging

        // Convert object to array
        cartItems = Object.values(cartItems);
        let cartList = $("#cart_list");
        cartList.empty(); // Clear old items
        let totalPrice = 0;
        cartItems.forEach((item) => {
        totalPrice += item.price * item.quantity;

            let cartItem = `
            <li>
                <a href="#" class="photo"><img src="<?= base_url() ?>${item.image}" class="cart-thumb" alt="" /></a>
                <h6><a href="#">${item.name}</a></h6>
                <p>${item.quantity}x - <span class="price">$${(item.price * item.quantity).toFixed(2)}</span></p>
            </li>`;

            cartList.append(cartItem);
        });

        let cartTotal = `
        <li class="total">
            <a href="<?= base_url(); ?>cart/view" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
            <span class="float-right"><strong>Total</strong>: $${totalPrice.toFixed(2)}</span>
        </li>`;

        cartList.append(cartTotal);
      
    },
    error: function (xhr, status, error) {
        console.error("AJAX Error:", error, xhr.responseText);
    }
   });
  });
       
    $("#authDropdown").change(function(){
        var selectedValue = $(this).val();
        
        if (selectedValue === "register") {
            $("#registerModal").modal("show");
        } else if (selectedValue === "login") {
            $("#loginModal").modal("show");
        }
        
        // Reset dropdown after selection
        $(this).val("");
    });

});
     $("#registerForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url('auth/register'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status) {
                 toastr.success(response.message);
                    $('#registerModal').modal('hide');
                    $('#loginModal').modal('show');
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });
  
  $("#loginForm").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: "<?php echo base_url('auth/login'); ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
            if (response.status) {
                toastr.success(response.message);

                // Check user type
                if (response.user_type === 'farmer') {
                    // Redirect farmer to my-account
                    window.location.href = "<?php echo base_url('my-account'); ?>";
                } else {
                    // Reload after 3 seconds for other user types
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            } else {
                // Show error message
                toastr.error(response.message);
            }
        }
    });
});

$(document).ready(function () {
    $(".add-to-cart").click(function () {
        var product_id = $(this).data("id");
        var product_name = $(this).data("name");
        var product_price = $(this).data("price");
        var product_image = $(this).data("image");
         var stock = $(this).data("stock");

        $.ajax({
            url: "<?= base_url('cart/add'); ?>", // Controller route
            type: "POST",
            data: {
                id: product_id,
                name: product_name,
                price: product_price,
                 image: product_image,
                 stock:stock
            },
            dataType: "json",
            success: function (response) {
                if (response.status == "success") {
                    toastr.success(response.message);
                    
                    // Reload the cart items (optional)
                    updateCartView();


                } else {
                    toastr.error(response.message);
                }
            }
        });
    });

    function updateCartView() {
        $("#cart_count").load("<?= base_url('cart/count'); ?>");
    }
});
$(document).ready(function () {
    $("#cart_count").load("<?= base_url('cart/count'); ?>");
});


  $("input[name='shipping-option']").on('change', function () {

        // Get shipping cost from the selected radio's value
        var shippingCost = parseFloat($("input[name='shipping-option']:checked").val());
        
        // Retrieve the base order subtotal (remove currency symbols and commas)
        var baseTotalText = $("#order_subtotal").text().replace(/[$,]/g, '').trim();
        var baseTotal = parseFloat(baseTotalText) || 0;
        
        var taxTotalText = $("#order_tax").text().replace(/[$,]/g, '').trim();
        var taxTotal = parseFloat(taxTotalText) || 0;
        
        // For example, if tax is already included in your subtotal or calculated separately,
        // you can simply add the shipping cost to the base subtotal.
        var newGrandTotal = baseTotal + shippingCost + taxTotal;

        // Update the Grand Total display
        $("#order_grand_total").text("$" + newGrandTotal.toFixed(2));
        
        // Also, update the Shipping Cost display if needed:
        if (shippingCost === 0) {
            $("#order_shipping").text("FREE");
        } else {
            $("#order_shipping").text("$" + shippingCost.toFixed(2));
        }
    });

    // Mapping of countries to their states/provinces
    var statesByCountry = {
        "United States": [
            "Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "Florida", "Georgia",
            "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland",
            "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey",
            "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina",
            "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming"
        ],
        "Canada": [
            "Alberta", "British Columbia", "Manitoba", "New Brunswick", "Newfoundland and Labrador", "Nova Scotia", "Ontario", "Prince Edward Island", "Quebec", "Saskatchewan"
        ],
        "India": [
            "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand",
            "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab",
            "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura", "Uttar Pradesh", "Uttarakhand", "West Bengal",
            "Andaman and Nicobar Islands", "Chandigarh", "Dadra and Nagar Haveli and Daman and Diu", "Delhi", "Jammu and Kashmir", "Ladakh", "Lakshadweep", "Puducherry"
        ],
        "Australia": [
            "New South Wales", "Queensland", "South Australia", "Tasmania", "Victoria", "Western Australia", "Australian Capital Territory", "Northern Territory"
        ],
        "United Kingdom": [
            "England", "Scotland", "Wales", "Northern Ireland"
        ],
        "Germany": [
            "Baden-Württemberg", "Bavaria", "Berlin", "Brandenburg", "Bremen", "Hamburg", "Hesse", "Lower Saxony", "Mecklenburg-Vorpommern",
            "North Rhine-Westphalia", "Rhineland-Palatinate", "Saarland", "Saxony", "Saxony-Anhalt", "Schleswig-Holstein", "Thuringia"
        ]
        // Add more countries and their states as needed
    };

    // Populate country dropdown
    var $countrySelect = $("#country");
    $.each(statesByCountry, function(country, states) {
        $countrySelect.append($("<option></option>").attr("value", country).text(country));
    });

    // Listen for changes on country dropdown
    $countrySelect.on("change", function() {
        var selectedCountry = $(this).val();
        var $stateSelect = $("#state");
        
        // Clear the state dropdown and add default option
        $stateSelect.empty();
        $stateSelect.append('<option value="">Choose...</option>');
        
        // If a valid country is selected, populate its states
        if (statesByCountry[selectedCountry]) {
            $.each(statesByCountry[selectedCountry], function(index, state) {
                $stateSelect.append($("<option></option>").attr("value", state).text(state));
            });
        }
    });

 var filterValue = "<?= isset($_GET['filter']) ? '.' . $_GET['filter'] : '*' ?>"; // Get filter from URL

    var $grid = $('.special-list').isotope({
        itemSelector: '.special-grid',
        layoutMode: 'fitRows'
    });

    // Apply filter from URL on page load
    if (filterValue !== '*') {
        $grid.isotope({ filter: filterValue });
    }

    // Handle button clicks to filter items dynamically
    $('.filter-button-group button').click(function(){
        var filterValue = $(this).attr('data-filter');
        $grid.isotope({ filter: filterValue });
        $('.filter-button-group button').removeClass('active');
        $(this).addClass('active');
    });

    $('#checkoutBtn').on('click', function (e) {
  let valid = true;
  let errorMessage = '';

  $('.qty').each(function () {
    let enteredQty = parseInt($(this).val());
    let stockQty = parseInt($(this).data('stock'));

    if (enteredQty > stockQty) {
      valid = false;
      errorMessage = 'Entered quantity exceeds available stock!';
      return false; // break out of .each loop
    }
  });

  if (!valid) {
    alert(errorMessage);
    e.preventDefault(); // prevent default behavior if using <a>
  } else {
    window.location.href = "<?= base_url(); ?>cart/checkout";
  }
});

</script>

</body>

</html>