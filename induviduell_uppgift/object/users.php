<?php
    include("../config/database_handler.php");


    class User {
        private $database_handler;
        private $username;
        private $token_validity_time = 15; // minutes


        public function __construct($database_handler_parameter_IN)
        {
            $this->database_handler = $database_handler_parameter_IN;
        }

        public function addUser($username, $password, $email) {
            $return_object = new stdClass();

            if ($this->isUsernameTaken($username) === false) {
                if ($this->isEmailTaken($email) === false) {

                    $return = $this->insertUserToDatabase($username, $password, $email);

                    if ($return !== false) {

                        $return_object->state = "SUCCESS";
                        $return_object->user = $return;

                    } else {
                        $return_object->state = "ERROR!";
                        $return_object->message = "Something Went wrong when trying to INSERT user!";

                    }

                } else {
                    $return_object->state = "ERROR!";
                    $return_object->message = "Email is taken!";
                }

            } else {
                $return_object->state = "ERROR!";
                $return_object->message = "Username is taken!";
            }

            return json_encode($return_object);
        } // addUser closed

        private function insertUserToDatabase($username, $password, $email) {
            $query = "INSERT INTO users (username, password, email) VALUES(:username, :password, :email)";
            $statementHandler = $this->database_handler->prepare($query);

            if ($statementHandler !== false ) {
                
                $encrypted_password = md5($password);

                $statementHandler->bindParam(':username', $username);
                $statementHandler->bindParam(':password', $encrypted_password);
                $statementHandler->bindParam(':email', $email);

                $statementHandler->execute();

                $last_inserted_user_id = $this->database_handler->lastInsertId();

                $query = "SELECT id, username, email FROM users WHERE id=:last_user_id";
                $statementHandler = $this->database_handler->prepare($query);

                $statementHandler->bindParam(':last_user_id', $last_inserted_user_id);

                $statementHandler->execute();

                return $statementHandler->fetch();

            } else {
                return false;
            }


        } // insertUserToDatabase closed 

        private function isUsernameTaken($username) {
            $query = "SELECT COUNT(id) FROM users WHERE username=:username";
            $statementHandler = $this->database_handler->prepare($query);

            if ($statementHandler !== false) {

                $statementHandler->bindParam(":username", $username);
                $statementHandler->execute();

                $usernameAmount = $statementHandler->fetch()[0];

                if ($usernameAmount > 0) {
                    return true;
                } else {
                    return false;
                    echo "Username already taken!";
                }

            } else {
                echo "Statementhandler YIKES!";
                die;
            }
        } // isUsernameTaken closed

        private function isEmailTaken($email) {
            $query = "SELECT COUNT(id) FROM users WHERE email=:email";
            $statementHandler = $this->database_handler->prepare($query);

            if ($statementHandler !== false) {
                $statementHandler->bindParam(':email', $email);
                $statementHandler->execute();

                $userAmount = $statementHandler->fetch()[0];

                if ($userAmount > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {

                echo "Statementhandler YIKES on isEmailTaken";
                die;
            }
        } // isEmailTaken closed

        public function loginUser($username, $password) {
            $return_object = new stdClass();

            $query = "SELECT id, username, password FROM users WHERE username=:username AND password=:password";
            $statementHandler = $this->database_handler->prepare($query);

            if ($statementHandler !== false) {
                $password_enc = md5($password);

                $statementHandler->bindParam(':username', $username);
                $statementHandler->bindParam(':password', $password_enc);

                $statementHandler->execute();
                $return = $statementHandler->fetch();

                if (!empty($return)) {
                    $this->username = $return['username'];

                    $return_object->token = $this->getToken($return['id'], $return['username']);
                    return json_encode($return_object);
                } else {
                    echo "fel login!";
                }

            } else {
                echo "Could not create statementhandler";
                die;
            }

        } // loginUser closed
        

        private function getToken($userID, $username) {

            $token = $this->checkToken($userID);

            return $token;

        } // getToken closed


        private function checkToken($userID) {

            $query = "SELECT token, date_updated, user_id FROM tokens WHERE user_id=:userID";
            $statementHandler = $this->database_handler->prepare($query);

            if ($statementHandler !== false) {

                $statementHandler->bindParam(":userID", $userID);
                $statementHandler->execute();
                $return = $statementHandler->fetch();

                if (!empty($return['token'])) {
                    // Token exists

                    $token_timestamp = $return['date_updated'];
                    $diff = time() - $token_timestamp;
                    if (($diff / 60) > $this->token_validity_time) {

                        $query = "DELETE FROM tokens WHERE user_id=:userID";
                        $statementHandler = $this->database_handler->prepare($query);

                        $statementHandler->bindParam('userID', $userID);
                        $statementHandler->execute();

                        return $this->createToken($userID);

                    } else {
                        return $return['token'];
                    }
                } else {
                    return $this->createToken($userID);
                }
            }

        } // checkToken closed

        private function createToken($userID_param) {

            $uniqToken = md5($this->username.uniqid('', true).time());

            $query = "INSERT INTO tokens (user_id, token, date_updated) VALUES(:userid, :token, :current_time)";
            $statementHandler = $this->database_handler->prepare($query);

            if ($statementHandler !== false) {
                $currentTime = time();
                $statementHandler->bindParam(":userid", $userID_param);
                $statementHandler->bindParam(":token", $uniqToken);
                $statementHandler->bindParam(":current_time", $currentTime, PDO::PARAM_INT);

                $statementHandler->execute();

                return $uniqToken;

            } else {
                return "Could not create a statementhandler";
            }

        } // createToken closed

        public function validateToken($token) {

            $query = "SELECT user_id, date_updated FROM tokens WHERE token=:token";
            $statementHandler = $this->database_handler->prepare($query);

            if ($statementHandler !== false) {
                $statementHandler->bindParam('token', $token);
                $statementHandler->execute();

                $token_data = $statementHandler->fetch();

                if (!empty($token_data['date_updated'])) {
                    $diff = time() - $token_data['date_updated'];

                    if ($diff / 60 < $this->token_validity_time) {
                        $query = "UPDATE tokens SET date_updated=:updated_date WHERE token=:token";
                        $statementHandler = $this->database_handler->prepare($query);

                        $updatedDate = time();
                        $statementHandler->bindParam(':updated_date', $updatedDate, PDO::PARAM_INT);
                        $statementHandler->bindParam(':token', $token);

                        $statementHandler->execute();

                        return true;
                    } else {
                        echo "Session closed duuuuee to inactivity <br />";
                        return false;
                    }
                } else {
                    echo "could not find token, please login first <br />";
                    return false;
                }
            } else {
                echo "could not create statementHandler<br />";
                return false;
            }

            return true;

        } // validateToken closed

        public function roleChecker($username) {
            $query = "SELECT username, role FROM users WHERE username='$username' AND role='admin'";
            $statementHandler = $this->database_handler->prepare($query);

            if ($statementHandler !== false) {

                $statementHandler->execute();
                return true;
                print_r($query);
            } else {
                echo "upsieee";
                return false;
            }
        } // RoleChecker() closed

        public function isAdmin($token)
        {
            $user_id = $this->getUserId($token);
            $user_data = $this->getUsers($user_id);
    
            if($user_data['role'] == 'admin') {
                return true;
                echo "yes";
            } else {
                return false;
                echo "no!";
            }
    
        } // isAdmin() closed;

        private function getUsers($userID) {

            $query = "SELECT id, username, role FROM users WHERE id=:userID";
            $statementHandler = $this->database_handler->prepare($query);
    
            if($statementHandler !== false) {
    
                $statementHandler->bindParam(":userID", $userID);
                $statementHandler->execute( );
    
                $return = $statementHandler->fetch();
    
                if(!empty($return)) {
                    return $return;
                } else {
                    return false;
                }
    
            } else {
                echo "Couldn't create statement handler!";
            }
    
        } // getUsers() closed 

        private function getUserId($token)
        {
            $query = "SELECT user_id FROM tokens WHERE token=:token";
            $statementHandler = $this->database_handler->prepare($query);
    
            if ($statementHandler !== false) {
    
                $statementHandler->bindParam(":token", $token);
                $statementHandler->execute();
    
                $return = $statementHandler->fetch()[0];
    
                if (!empty($return)) {
                    return $return;
                } else {
                    return -1;
                }
            } else {
                echo "Couldn't create a statementhandler!";
            }
        } // getUserId


    } // class USER closed


?>