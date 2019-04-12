package com.ExodiaSolutions.sunnynarang.itmexodia.students;

import android.app.ProgressDialog;
import android.content.Context;
import android.graphics.Color;
import android.graphics.Typeface;
import android.graphics.drawable.Drawable;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;
import com.facebook.drawee.generic.GenericDraweeHierarchy;
import com.facebook.drawee.generic.GenericDraweeHierarchyBuilder;
import com.facebook.drawee.generic.RoundingParams;
import com.facebook.drawee.view.SimpleDraweeView;
import org.apache.commons.io.FileUtils;
import org.json.JSONException;
import org.json.JSONObject;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.text.DecimalFormat;

import uk.co.chrisjenx.calligraphy.CalligraphyContextWrapper;

public class NewProfile extends AppCompatActivity {
    TextView namev,rollv,phonev,emailv,attendancev,addressv,dobv,guardianv,short_bio,presentv,outofv,v;
    ProgressDialog pd;
    String roll,offline_profile="";


    @Override
    protected void attachBaseContext(Context newBase) {
        super.attachBaseContext(CalligraphyContextWrapper.wrap(newBase));
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_test_profile);
        android.support.v7.app.ActionBar actionBar = getSupportActionBar();
        actionBar.hide();
        pd = new ProgressDialog(NewProfile.this);


        namev= (TextView) findViewById(R.id.std_profile_name);
        rollv= (TextView) findViewById(R.id.std_profile_roll);
        short_bio= (TextView) findViewById(R.id.profile_details);
        v= (TextView) findViewById(R.id.av);
        Typeface type = Typeface.createFromAsset(getAssets(),"fonts/TitilliumWeb-Light.ttf");
        Typeface type1 = Typeface.createFromAsset(getAssets(),"fonts/Oswald-Regular.ttf");
        namev.setTypeface(type1);
        rollv.setTypeface(type);
        short_bio.setTypeface(type);

        roll = getIntent().getStringExtra("roll");
        String image = getIntent().getStringExtra("image");
readItems();
        //set headers view font
        v= (TextView) findViewById(R.id.av);
        v.setTypeface(type1);
        v= (TextView) findViewById(R.id.av1);
        v.setTypeface(type1);
        v= (TextView) findViewById(R.id.av2);
        v.setTypeface(type1);

        v= (TextView) findViewById(R.id.av3);
        v.setTypeface(type1);
        v= (TextView) findViewById(R.id.av4);
        v.setTypeface(type1);
        v= (TextView) findViewById(R.id.av5);
        v.setTypeface(type1);//upto here
        rollv= (TextView) findViewById(R.id.std_profile_roll);
        short_bio= (TextView) findViewById(R.id.profile_details);
        phonev= (TextView) findViewById(R.id.std_profile_phone);
        emailv = (TextView) findViewById(R.id.std_profile_email);
        attendancev= (TextView) findViewById(R.id.std_profile_academics);
        addressv= (TextView) findViewById(R.id.std_profile_address);
        dobv= (TextView) findViewById(R.id.std_profile_dob);
        guardianv= (TextView) findViewById(R.id.std_guardian);
        presentv = (TextView) findViewById(R.id.std_profile_present);
        outofv = (TextView) findViewById(R.id.std_profile_outof);



        if(!offline_profile.equalsIgnoreCase("")){
            try {

                JSONObject jsonObject = new JSONObject(offline_profile);
                String name=jsonObject.optString("name");
                String roll=jsonObject.optString("roll");
                String out_of=jsonObject.optString("out_of");
                String present=jsonObject.optString("present");
                String contact = jsonObject.optString("email");
                String phone = jsonObject.optString("phone");
                String address1 = jsonObject.optString("address1");
                String address2 = jsonObject.optString("address2");
                String dob = jsonObject.optString("dob");
                String f_name = jsonObject.optString("f_name");
                String f_mob = jsonObject.optString("f_mob");
                String class_name = jsonObject.optString("class_name");
                String branch = jsonObject.optString("branch");
                String sem = jsonObject.optString("sem");
                // Toast.makeText(Std_profile.this,""+jsonObject.optString("status"),Toast.LENGTH_LONG).show();
              //  Toast.makeText(NewProfile.this, ""+branch+class_name, Toast.LENGTH_SHORT).show();
                if(out_of.equalsIgnoreCase("")){out_of="0";}
                if(present.equalsIgnoreCase("")){present="0";}
                Float att = Float.parseFloat(present)/Float.parseFloat(out_of);
                DecimalFormat df = new DecimalFormat("#.#");
                String per = df.format(att*100);
                if(present.equalsIgnoreCase("0"))
                    per="0.0";
                attendancev.setText(""+per+" %");
                namev.setText(name);

                short_bio.setText(branch+" | "+class_name+" | Semester- "+sem);
                rollv.setText(roll.toUpperCase());
                phonev.setText(phone+"");
                emailv.setText(contact+"");
                addressv.setText(address1+"\n"+address2);
                dobv.setText(dob);
                guardianv.setText(f_name+" ("+f_mob+")");
                presentv.setText(""+present);
                outofv.setText(""+out_of);

            } catch (JSONException e) {
                e.printStackTrace();
            }
        }


         if(isNetworkAvailable()){

            final ProfileLoader profileLoader = new ProfileLoader();
            profileLoader.execute(roll);
             Handler handler = new Handler();
             handler.postDelayed(new Runnable()
             {
                 @Override
                 public void run() {
                     if ( profileLoader.getStatus() == AsyncTask.Status.RUNNING )
                     {profileLoader.cancel(true);
                         Toast.makeText(NewProfile.this, "Time OUT", Toast.LENGTH_SHORT).show();
                         if(pd.isIndeterminate())
                         pd.dismiss();
                     }
                 }
             }, 20000 );}
            else{
             Toast.makeText(this, "No Internet Connection", Toast.LENGTH_SHORT).show();

        }
        Uri imageUri = Uri.parse("https://exodia-incredible100rav.c9users.io/itm/img/"+image);
        SimpleDraweeView draweeView = (SimpleDraweeView) findViewById(R.id.std_profile_img);
        Drawable myIcon = getResources().getDrawable( R.drawable.user_wh );

        GenericDraweeHierarchyBuilder builder =
                new GenericDraweeHierarchyBuilder(getResources());
        GenericDraweeHierarchy hierarchy = builder
                .setFadeDuration(300)
                .setPlaceholderImage(myIcon)
                .build();
        draweeView.setHierarchy(hierarchy);

        RoundingParams roundingParams = RoundingParams.fromCornersRadius(5f);
        roundingParams.setBorder(Color.parseColor("#ffffff"), 3);
        roundingParams.setRoundAsCircle(true);
        draweeView.getHierarchy().setRoundingParams(roundingParams);

        draweeView.setImageURI(imageUri);


    }

    class ProfileLoader extends AsyncTask<String,Void,String>{


        @Override
        protected void onPreExecute() {

            super.onPreExecute();
            if(offline_profile.equalsIgnoreCase("")){

            pd.setTitle("Loading.");
            pd.setMessage("Building Profile..");
            pd.setCancelable(false);
            pd.show();}
        }

        @Override
        protected String doInBackground(String... strings) {
            String rollno=strings[0];
            String login_url = "https://exodia-incredible100rav.c9users.io/android/php/getprofile.php";

            try {

                URL url = new URL(login_url);
                HttpURLConnection httpurlconnection = (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                String post_data = URLEncoder.encode("roll", "UTF-8") + "=" + URLEncoder.encode(rollno, "UTF-8") ;
                bufferedwriter.write(post_data);
                bufferedwriter.flush();
                bufferedwriter.close();

                InputStream inputstream = httpurlconnection.getInputStream();
                BufferedReader bufferedreader = new BufferedReader(new InputStreamReader(inputstream, "iso-8859-1"));
                String result = "";
                String line = "";
                while ((line = bufferedreader.readLine()) != null) {
                    result += line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();

                return result;

            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

            return "";


        }
        @Override
        protected void onPostExecute(String s) {
         //  Toast.makeText(NewProfile.this, ""+s, Toast.LENGTH_SHORT).show();
if(offline_profile.equalsIgnoreCase(""))
            pd.dismiss();

            if(!s.equalsIgnoreCase("0")){
                writeItems(s);
            try {

                JSONObject jsonObject = new JSONObject(s);
                String name=jsonObject.optString("name");
                String roll=jsonObject.optString("roll");
                String out_of=jsonObject.optString("out_of");
                String present=jsonObject.optString("present");
                String contact = jsonObject.optString("email");
                String phone = jsonObject.optString("phone");
                String address1 = jsonObject.optString("address1");
                String address2 = jsonObject.optString("address2");
                String dob = jsonObject.optString("dob");
                String f_name = jsonObject.optString("f_name");
                String f_mob = jsonObject.optString("f_mob");
                String class_name = jsonObject.optString("class_name");
                String branch = jsonObject.optString("branch");
                String sem = jsonObject.optString("sem");
                // Toast.makeText(Std_profile.this,""+jsonObject.optString("status"),Toast.LENGTH_LONG).show();
              //  Toast.makeText(NewProfile.this, ""+branch+class_name, Toast.LENGTH_SHORT).show();
                if(out_of.equalsIgnoreCase("")){out_of="0";}
                if(present.equalsIgnoreCase("")){present="0";}
                Float att = Float.parseFloat(present)/Float.parseFloat(out_of);
                DecimalFormat df = new DecimalFormat("#.#");
                String per = df.format(att*100);
                if(present.equalsIgnoreCase("0"))
                    per="0.0";
               attendancev.setText(""+per+" %");
                namev.setText(name);

                short_bio.setText(branch+" | "+class_name+" | Semester- "+sem);
                rollv.setText(roll.toUpperCase());
                phonev.setText(phone+"");
                emailv.setText(contact+"");
                addressv.setText(address1+"\n"+address2);
                dobv.setText(dob);
                guardianv.setText(f_name+" ("+f_mob+")");
                presentv.setText(""+present);
                outofv.setText(""+out_of);

            } catch (JSONException e) {
                e.printStackTrace();
            }

        }}

    }

    public void back(View v){
        finish();
    }
    private void writeItems(String s) {

        File filesDir = getFilesDir();
        File todoFile = new File(filesDir,roll+"profile.txt");
        try {


            FileUtils.writeStringToFile(todoFile ,s);   // TODO: add depenencies for fill utils
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
    private void readItems()  {

        File filesDir = getFilesDir();
        File todoFile = new File(filesDir,roll+"profile.txt");
        try {
            offline_profile = new String(FileUtils.readFileToString(todoFile));
        } catch (IOException e) {
            offline_profile = "";
        }
    }
    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }




}
