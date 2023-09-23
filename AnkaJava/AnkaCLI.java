import java.io.FileWriter;
import java.io.IOException;
import java.io.File;
import java.io.FileNotFoundException;
import java.util.Scanner;

public class AnkaCLI {
    
    public static boolean createFile(String fileName) {
        try {
            File fileObj = new File(fileName); //Create a file object

            if (fileObj.createNewFile()) { //if the file is created, return true
                System.out.println(fileName + " file created!");
                return true;
            } else {
                System.out.println("The " + fileName + " already exists.");
                return true;
            }
        } catch (IOException err) { // If any error occurs during creating file, then notify user and return false
            System.out.println("Failed to create " + fileName + " text file.");
            return false;
        }
    }

    public static boolean writeToFile(String fileName, String text) {
        try { // Create a FileWriter object that appends onto already existing contents of the text file
                FileWriter writeObject = new FileWriter(fileName, true);
                
                if ( text != "\n") {
                    writeObject.write(text + ";");
                } else {
                    writeObject.write("\n");
                }
                writeObject.close();
                return true;
        } catch (IOException err) { // If any error occurs during writing file, then notify user and return false
            System.out.println("Failed to write to " + fileName + " text file.");
            return false;
        }

    }

    public static boolean writeToParticipantFile(String fileName, String text) { //Function for specifically updating PsrticipantsID file
        try { // Create a FileWriter object that replaces already existing contents of the text file
                FileWriter writeObject = new FileWriter(fileName, false);
                
                writeObject.write(text);

                writeObject.close();
                return true;
        } catch (IOException err) { // If any error occurs during writing file, then notify user and return false
            System.out.println("Failed to write to " + fileName + " text file.");
            return false;
        }

    }

    public static boolean writeToRequestsFile(String fileName, String text) { // Function for specifically updating the performance requests file
        try { // Create a FileWriter object that appends onto already existing contents of the text file
                FileWriter writeObject = new FileWriter(fileName, true);
                
                writeObject.write(text);

                writeObject.close();
                return true;
        } catch (IOException err) { // If any error occurs during writing file, then notify user and return false
            System.out.println("Failed to write to " + fileName + " text file.");
            return false;
        }

    }

    public static boolean registerParticipant(String[] particpantDetails, String textFileName) {
            if(particpantDetails.length == 5) { //If the user input is not as shown in the menu, return false

                for (int i = 1; i < particpantDetails.length; i++) { //For each user input (detail), write to text file
                    writeToFile(textFileName, (particpantDetails[i]));
                }
                String partID = Integer.toString(generateID()); //Generate ID for the particioant
                writeToFile(textFileName, "\n");

                System.out.println("***This is your ID for use when registering products and requesting perfomance: " + partID);
                return true;
            } else {
                System.out.println("Please fill in all the registration details");
                return false;
            }
    }

    public static void postProduct(String[] productDetails, String textFileName) {
        String productName = productDetails[1]; // Store product name in temporary variable
        String description = "";

        for ( int i = 2; i < productDetails.length; i++) { //for every word in the product details after product name, append to description
            description += (productDetails[i] + " ");
        }

        Scanner productValues = new Scanner(System.in);
        System.out.println("Please provide the product quantity, rate and participant ID");
        // String inputValues[] = productValues.next()).split(" ");

        String productQuantity = productValues.next();
        String productRate = productValues.next();
        String participantID = productValues.next();
        
        //Write product details to given text files
        writeToFile(textFileName, productName);
        writeToFile(textFileName, productQuantity);
        writeToFile(textFileName, productRate);
        writeToFile(textFileName, description);
        writeToFile(textFileName, (participantID));
        writeToFile(textFileName, "\n");

    }

    public static void getPerformance() {
        System.out.println("Getting performance......");
        
        // Get ID of requesting participant
        Scanner requestsScanner = new Scanner(System.in);
        System.out.println("Please enter your id");
        int requestsID = requestsScanner.nextInt(); 

        try {
            // Create file object that is used to read performance details written by the cronjob in the text file
            // If the user ID is in file then print it to program
            File perfomanceFile = new File("Performance.txt");
            requestsScanner = new Scanner(perfomanceFile);

            while (requestsScanner.hasNextLine()) {
                String performance[] = requestsScanner.nextLine().split(";");
                if (Integer.parseInt(performance[0]) == requestsID) {
                    System.out.println(performance[1]);
                    return;
                }
            }

        } catch (FileNotFoundException err) {
            System.out.println("Error while reading from Performance.txt file");
            err.printStackTrace();
            return;
        }
        // If requesting participant ID perfomance not in file then write a request to requests file and tell user to check later.
        writeToRequestsFile("PerformanceRequests.txt", Integer.toString(requestsID));
        writeToRequestsFile("PerformanceRequests.txt", "\n");

        System.out.println("Dear participant, run the performance command after 1 minute to get your perfomance stats.");

    }

    public static int generateID() { // This function helps keep track of participant IDs written in a file
        int new_ID = 0; //create temporary int for new ID

        try {
            File ID_File = new File("ParticipantsID.txt");
            String participantID = "";
            Scanner ID_Reader = new Scanner(ID_File);
    
            if (ID_File.length() != 0) { // if the ids file is not empty then get last recorded ID in file
                while(ID_Reader.hasNextLine()) {
                    participantID = ID_Reader.nextLine();
                    new_ID = Integer.parseInt(participantID);

                    //get last recorded ID and add one to it
                    new_ID += 1;

                    // Write new used ID to the file
                    writeToParticipantFile("ParticipantsID.txt", Integer.toString(new_ID));
            
                    return new_ID;
                } 
            } 
            else {
                // if there is no last recorded id then write the new ID to file 
                new_ID += 1;


                writeToParticipantFile("ParticipantsID.txt", Integer.toString(new_ID));
        
                return new_ID;
            }

        } catch (FileNotFoundException err) {
            System.out.println("Error while reading from ParticipantsID.txt file");
            err.printStackTrace();
            return 0;
        }
        return 0;
    }

    public static void displayMenu() {
        //MENU
        System.out.println("\n**************************************************************************");
        System.out.println("Welcome to Anka Command Line Interface.");
        System.out.println("Please use the following commands to perform the different actions. \n");

        //Commands
        System.out.println("Register name password product date_of_birth");
        System.out.println("Post_product product_name \"description\"");
        System.out.println("Perfomance");
        System.out.println("Exit");

        //Menu Note
        System.out.println("\nNote: In case of more than two names, put a hyphen(-) between the names.");
        System.out.println("Note: Date should be in the format yyyy-mm-dd");
        System.out.println("**************************************************************************\n");
    }
    public static void main(String[] args) {

        //Initialize variables needed
        Scanner commandScanner = new Scanner(System.in); //Input object for getting commands from user

        //create text files required
        createFile("Participants.txt");
        createFile("Products.txt");
        createFile("ParticipantsID.txt");
        createFile("PerformanceRequests.txt");
        createFile("Performance.txt");

        displayMenu(); //Display Menu 

        while(true) {

            System.out.println("Enter command"); //Prompt user for commands

            String commands[] = commandScanner.nextLine().split(" "); //Split the command using the space and store the parts of command in an array.

            //if first word in command is valid then act accordingly.
            if (commands[0].equalsIgnoreCase("Register")) {

                registerParticipant(commands, "Participants.txt");
                commands = null;

            } else if (commands[0].equalsIgnoreCase("Post_product")) {
            
                postProduct(commands, "Products.txt");
                commands = null;

            } else if (commands[0].equalsIgnoreCase("Performance")) {
                getPerformance();
                commands = null;
                
            } else if (commands[0].equalsIgnoreCase("exit")) {
                break;
                
            } else { // If the user input is invalid remind them to follow rules.
                System.out.println("Please follow the menu to enter correct commands");
            }
        }

        //Close program and scanner object
        System.out.println("Program closing......");
        commandScanner.close();
    }
}