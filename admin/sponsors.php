<?php
include('header.php');
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Sponsors</h1>
        <a href="sponsorReg.php" class="btn">Register</a>

    </div>
    <hr>

    <div class="container_body">
        <div class="details_table">

            <div class="repot_table"><input type="text" id="searchBox-2" placeholder="Search Here">
                <form action="export.php" method="post">

                    <button name="sponsor_repo" type="submit" class="btn ">
                        Export <ion-icon class="report_icon" name="document-outline"></ion-icon>
                        <ion-icon class="report_icon" name="download-outline">
                        </ion-icon>
                    </button>
                </form>
            </div>

            <table id="table-2">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Company Name</th>
                        <th class="col2">Edit</th>

                    </tr>
                </thead>
                <?php 
                $res=mysqli_query($con,"SELECT * FROM `sponsors`");
                while($row=mysqli_fetch_array($res))
                {
                ?>

                <tbody>
                    <tr>
                        <td><img src="../<?php echo $row["image"]; ?>" width="50px;" heigth="50px;" alt="image"></td>
                        <td><?php echo $row["f_name"]; ?></td>
                        <td><?php echo $row["l_name"]; ?></td>
                        <td><?php echo $row["contact"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["company"]; ?></td>
                        <td class="col">
                            <a href="edit_sponsor.php?id=<?php echo $row["id"]; ?>" class="action edit ">Edit</a>
                            <a href="donate_sponsor.php?id=<?php echo $row["id"]; ?>" class="action edit ">Donate</a>
                            <input type="hidden" class="delete_id_value" value="<?php echo $row["id"]; ?>">
                            <a href="javascripit:void(0)" class="delete_btn_ajax action edit">Delete</a>
                        </td>

                    </tr>

                </tbody>

                <?php 
                }
                ?>
            </table>

        </div>

    </div>

</div>

<script>
var searchBox_2 = document.getElementById("searchBox-2");
searchBox_2.addEventListener("keyup", function() {
    var keyword = this.value;
    keyword = keyword.toUpperCase();
    var table_2 = document.getElementById("table-2");
    var all_tr = table_2.getElementsByTagName("tr");
    for (var i = 0; i < all_tr.length; i++) {
        var id_column = all_tr[i].getElementsByTagName("td")[0];
        var fname_column = all_tr[i].getElementsByTagName("td")[1];
        var lname_column = all_tr[i].getElementsByTagName("td")[2];
        var email_column = all_tr[i].getElementsByTagName("td")[4];
        var company_column = all_tr[i].getElementsByTagName("td")[5];


        if (fname_column && lname_column) {
            var id_value = id_column.textContent || id_column.innerText;
            var fname_value = fname_column.textContent || fname_column.innerText;
            var lname_value = lname_column.textContent || lname_column.innerText;
            var email_value = email_column.textContent || email_column.innerText;
            var company_value = company_column.textContent || company_column.innerText;

            id_value = id_value.toUpperCase();
            fname_value = fname_value.toUpperCase();
            lname_value = lname_value.toUpperCase();
            email_value = email_value.toUpperCase();
            company_value = company_value.toUpperCase();

            if ((id_value.indexOf(keyword) > -1) || (fname_value.indexOf(keyword) > -1) || (lname_value
                    .indexOf(keyword) > -1) || (email_value
                    .indexOf(keyword) > -1) || (company_value.indexOf(keyword) > -1)) {
                all_tr[i].style.display = ""; // show
            } else {
                all_tr[i].style.display = "none"; // hide
            }
        }
    }
})
</script>

<script>
$(document).ready(function() {

    $('.delete_btn_ajax').click(function(e) {
        e.preventDefault();
        var deleteid = $(this).closest("tr").find('.delete_id_value').val();
        //console.log(deleteid);


        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        type: "POST",
                        url: "",
                        data: {
                            "delete_btn_set": 1,
                            "delete_id": deleteid,
                        },

                        success: function(response) {

                            swal("Sponsor Delete Successfully.!", {
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });
                }
            });
    });

});
</script>


<?php
 
  if(isset($_POST['delete_btn_set']))

  {
      $del_id = $_POST['delete_id'];

      $reg_query = "DELETE FROM `sponsors` WHERE id='$del_id'";
      $reg_query_run = mysqli_query($con, $reg_query);
  }
?>

<?php
include('footer.php');
?>