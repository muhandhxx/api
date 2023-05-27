<?php
class DbHelper
{


    private $conn;

    function createDbConnection()
    {
        try {
            $this->conn = new mysqli("localhost", "root", "", "api");
        } catch (Exception $error) {
            echo $error->getMessage();

        }
    }


    function insertNewEmpolye($name,$age,$email,$image,$salary){
        try{

            $file_link = $this->saveImage($image);

            $sql = "INSERT INTO employees (name,age,email,image,salary)VALUES ('$name','$age','$email','$file_link','$salary')";
            $result =  $this->conn->query($sql);
            if($result==true){
                    $this->createResponse(true,1,
                        $this->createEmpolyeResponse($this->conn->insert_id,
                        $name,
                        $age,
                        $email,
                        $file_link,
                        $salary

                    )
                );
            }else{
                $this->createResponse(false,"data has not been inserted");

            }

        }catch (Exception $error){
            $this->createResponse(false,$error->getMessage());


        }
    }






    function getAllEmpoyles()
    {
        try {
            $sql = "select * from  employees";
            $result = $this->conn->query($sql);

            $count = $result->num_rows;
            if ($count > 0) {
                $all_students_array = array();
                while ($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $name = $row["name"];
                    $age = $row["age"];
                    $email = $row["email"];
                    $image = $row["image"];
                    $salary =$row["salary"];

                    // create associative array for the student
                    $student_array = $this->createEmpolyeResponse($id, $name,$age,$email,$image,$salary);
                    array_push($all_students_array, $student_array);
                }
                $this->createResponse(true, $count,$all_students_array);
            } else {
                throw  Exception("No Data Found");
            }
        } catch (Exception $exception) {
            $this->createResponse(false, 0);
        }


    }

    function getEmployeById($id)
    {
        $sql = "select * from employees where id = $id";
        $result = $this->conn->query($sql);
        try {
            if ($result->num_rows == 0) {
                throw new Exception("there are no employees with the passed id");
            } else {
                $row = $result->fetch_assoc();
                $id = $row["id"];
                $name = $row["name"];
                $age = $row["age"];
                $email = $row["email"];
                $image = $row["image"];
                $salary =$row["salary"];

                // create associative array for the student
                $student_array = $this->createEmpolyeResponse($id, $name,$age,$email,$image,$salary);
                $this->createResponse(true, 1,$student_array);

            }
        } catch (Exception $exception) {
            http_response_code(400);
            $this->createResponse(false, 0);
        }

    }

    function deleteEmploye($id)
    {
        try {
            $sql = "delete from employees where id = $id";
            $result = $this->conn->query($sql);

            if (mysqli_affected_rows($this->conn) > 0) {
                $this->createResponse(true, 1);
            } else {
                throw new Exception("There are no employees with the passed id");
            }
        } catch (Exception $exception) {
            $this->createResponse(false, 0);
        }
    }

    function updateEmploye($id, $name,$age, $email,$image,$salary)
    {
        try {
            $image_url = $this->saveImage($image);
            $sql = "UPDATE `employees` SET `name`='$name',`age`='$age',`email`='$email',`image`='$image_url',`salary`='$salary' WHERE  id ='$id'";
            $result = $this->conn->query($sql);
            if (mysqli_affected_rows($this->conn) > 0) {
                $this->createResponse2(true, 1);

            } else {
                throw new Exception("There are no employees with the passed id");

        }
        }catch (Exception $exception) {
            $this->createResponse2(false, 0 );
        }
    }

    function saveImage($file)
    {
        $dir_name = "images/";
        $fullPath = $dir_name . $file["name"];
        move_uploaded_file($file["tmp_name"], $fullPath);
        $file_link = "http://localhost/ApiProject/$fullPath";
        return $file_link;
    }

    function createResponse($isSuccess, $count,$data)
    {
        echo json_encode(array(
            "success" => $isSuccess,
            "count" => $count,
            "data" => $data
        ));
    }
    function createResponse2($isSuccess, $count)
    {
        echo json_encode(array(
            "success" => $isSuccess,
            "count" => $count
        ));
    }

    function createEmpolyeResponse($id, $name,$age, $email, $image_url,$salary)
    {
        return array(
            "id" => $id,
            "name" => $name,
            "age" => $age,
            "email" => $email,
            "image" => $image_url,
            "salary" => $salary,

        );

    }
}
?>