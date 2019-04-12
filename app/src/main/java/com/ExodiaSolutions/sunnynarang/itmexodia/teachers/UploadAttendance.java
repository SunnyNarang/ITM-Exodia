package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.Link;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;

import org.apache.commons.io.FileUtils;
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
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Locale;

public class UploadAttendance extends AppCompatActivity {
    ArrayList<Att_list_class> arrayList = new ArrayList<>();
    String offline_temp_att;
    CustomAdapter3 adapter;
    ProgressDialog pd;
    String time,class_id,subject_id,teacher_roll,stu_att,timestamp;
    ListView list;
    int position;
    String edit_date;
    String upload="0";
    String[] datarow;
    String roll_teacher;
    String subject;
    String teacher1;
    String teacher2;
    String tid;
    String time1,time2;
    String period;
    String periodTo;
    String date;
    String time0;
    String section_id;
    String regId;
    String attendance;
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                UploadAttendance.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_upload_attendance);
        roll_teacher = getIntent().getStringExtra("roll");
       // Toast.makeText(this, ""+roll_teacher, Toast.LENGTH_SHORT).show();
        readItems();
        final ActionBar action = getSupportActionBar();
        action.setTitle("Offline Attendance");
        action.setHomeButtonEnabled(true);
        action.setDisplayHomeAsUpEnabled(true);
        if(!offline_temp_att.equalsIgnoreCase("")) {
            datarow = offline_temp_att.split("&&");

            for (int i = 0; i < datarow.length; i++) {
                String[] cl_details = datarow[i].split("\\+");
                Att_list_class a = new Att_list_class(cl_details[0], cl_details[1], cl_details[2], cl_details[3], cl_details[10], cl_details[4]);
                arrayList.add(a);

            }

            list = (ListView) findViewById(R.id.offline_att_listview);
            adapter = new CustomAdapter3(UploadAttendance.this, arrayList);
            list.setAdapter(adapter);
            list.setOnItemLongClickListener(new AdapterView.OnItemLongClickListener() {

                public boolean onItemLongClick(AdapterView<?> arg0, View v,
                                               final int index, long arg3) {
                    // TODO Auto-generated method stub

                    AlertDialog.Builder builder = new AlertDialog.Builder(UploadAttendance.this);
                    builder.setMessage("Do you Want to Delete Attendace?")
                            .setCancelable(false)
                            .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int id) {
                                    String tobewritten="";
                                    for(int i=0;i<datarow.length;i++)
                                    {
                                        if(i!=index){
                                            if(tobewritten.equalsIgnoreCase(""))
                                            {
                                                tobewritten=datarow[i];
                                            }
                                            else {
                                                tobewritten=tobewritten+"&&"+datarow[i];

                                            }}
                                    }
                                    writeItems(tobewritten);
                                    readItems();
                                    datarow = offline_temp_att.split("&&");
                                    arrayList.clear();
                                    if(!offline_temp_att.equalsIgnoreCase("")){
                                        for(int i= 0 ; i< datarow.length;i++)
                                        {
                                            String[] cl_details = datarow[i].split("\\+");
                                            Att_list_class a = new Att_list_class(cl_details[0], cl_details[1], cl_details[2], cl_details[3], cl_details[10], cl_details[4]);
                                            arrayList.add(a);
                                        }
                                    }adapter.notifyDataSetChanged();

                                }
                            })
                            .setNegativeButton("No", new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int id) {
                                    dialog.cancel();
                                }
                            });
                    AlertDialog alert = builder.create();
                    alert.show();


                    return true;
                }
            });
            list.setOnItemClickListener(
                    new AdapterView.OnItemClickListener() {
                        public void onItemClick(AdapterView<?> parent, View v, int pos, long id) {
                            position = pos;
                            AlertDialog.Builder builder = new AlertDialog.Builder(UploadAttendance.this);
                            builder.setMessage("Upload Attendace?")
                                    .setCancelable(false)
                                    .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                                        public void onClick(DialogInterface dialog, int id) {
                                           if(isNetworkAvailable()){
                                            String[] class_details = datarow[position].split("\\+");
                                               subject=class_details[4];
                                               teacher1=class_details[5];
                                               teacher2=class_details[6];
                                               tid=class_details[7];
                                               period=class_details[8];
                                               periodTo=class_details[9];
                                               date=class_details[10];
                                               time0=class_details[11];
                                               section_id=class_details[12];
                                                regId=class_details[13];
                                                attendance=class_details[14];
                                               if(attendance.equalsIgnoreCase("null"))
                                                   attendance="";
                                          //  Toast.makeText(UploadAttendance.this, "subject : "+subject+"\nteacher 1 : "+teacher1+"\nteacher 2 : "+teacher2+"\ntid : "+tid+"\nperiod : "+period+"\nperiodTo : "+periodTo+"\ndate : "+date+"\ntime : "+time0+"\nsection_id : "+section_id+"\nregId : "+regId+"\nattendance : "+attendance, Toast.LENGTH_LONG).show();
                                            final AttendanceUploader attendanceUploader = new AttendanceUploader(UploadAttendance.this);
                                            attendanceUploader.execute();

                                               Handler handler = new Handler();
                                               handler.postDelayed(new Runnable()
                                               {
                                                   @Override
                                                   public void run() {
                                                       if ( attendanceUploader.getStatus() == AsyncTask.Status.RUNNING )
                                                       {attendanceUploader.cancel(true);
                                                           Toast.makeText(UploadAttendance.this, "Time OUT", Toast.LENGTH_SHORT).show();
                                                           if(pd.isIndeterminate())
                                                           pd.dismiss();
                                                       }
                                                   }
                                               }, 20000 );
                                           }
                                            else
                                           {
                                               Toast.makeText(UploadAttendance.this, "Please Connect to Internet to Upload", Toast.LENGTH_SHORT).show();
                                           }
                                        }
                                    })

                                    .setNegativeButton("No", new DialogInterface.OnClickListener() {
                                        public void onClick(DialogInterface dialog, int id) {
                                            dialog.cancel();
                                        }
                                    });
                            AlertDialog alert = builder.create();
                            alert.show();

                        }
                    }


            );

        }
        else
        {
            Toast.makeText(this, "Nothing To Upload", Toast.LENGTH_SHORT).show();
            finish();
        }
    }

    class CustomAdapter3 extends ArrayAdapter<Att_list_class> {
        Context c;

        public CustomAdapter3(Context context, ArrayList<Att_list_class> arrayList) {
            super(context, R.layout.offline_attendance_card, arrayList);
            this.c = context;
        }


        @Override
        public View getView(int pos, View convertView, ViewGroup parent) {

            LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
            convertView = li.inflate(R.layout.offline_attendance_card, parent, false);


            TextView strip1 = (TextView) convertView.findViewById(R.id.att_card_strip1);
            TextView strip2 = (TextView) convertView.findViewById(R.id.att_card_strip2);

            Att_list_class a = getItem(pos);

            strip1.setText(a.getClasses()+" | Sem - "+a.getSem()+" | "+a.getsubject()+" | "+a.getDate());
            strip2.setText(a.getCourse()+" | "+a.getBranch());

            return convertView;

        }
    }

    private void readItems()  {
        File filesDir = getFilesDir();
      //  Toast.makeText(this, ""+teacher_roll, Toast.LENGTH_SHORT).show();
        File todoFile = new File(filesDir,roll_teacher+"temp_attendance.txt");
        try {
            offline_temp_att = new String(FileUtils.readFileToString(todoFile));
        } catch (IOException e) {
            offline_temp_att = "";
        }
    }

    public class AttendanceUploader extends AsyncTask<Void,Void,String> {

        Context context;
        AttendanceUploader(Context context)
        {
            this.context=context;
        }


        @Override
        protected String doInBackground(Void... params) {

            String login_url= null;

            if( Link.getInstance().getHashMapLink().containsKey("upload_att")){
               login_url=Link.getInstance().getHashMapLink().get("upload_att");
            }
            String s[] = time0.split(" - ");
            time1=s[0];
            time2=s[1];


            try{

                URL url =new URL(login_url);
                HttpURLConnection httpurlconnection= (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestProperty("Accept","text/html");
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));
                String post_data = URLEncoder.encode("subject", "UTF-8") + "=" + URLEncoder.encode(subject, "UTF-8")+ "&"
                        + URLEncoder.encode("teacher1", "UTF-8") + "=" + URLEncoder.encode(teacher1, "UTF-8")+ "&"
                        + URLEncoder.encode("teacher2", "UTF-8") + "=" + URLEncoder.encode(teacher2, "UTF-8")+ "&"
                        + URLEncoder.encode("tid", "UTF-8") + "=" + URLEncoder.encode(tid, "UTF-8")+ "&"
                        + URLEncoder.encode("period", "UTF-8") + "=" + URLEncoder.encode(period, "UTF-8")+ "&"
                        + URLEncoder.encode("periodTo", "UTF-8") + "=" + URLEncoder.encode(periodTo, "UTF-8")+ "&"
                        + URLEncoder.encode("time1", "UTF-8") + "=" + URLEncoder.encode(time1, "UTF-8")+ "&"
                        + URLEncoder.encode("time2", "UTF-8") + "=" + URLEncoder.encode(time2, "UTF-8")+ "&"
                        + URLEncoder.encode("date", "UTF-8") + "=" + URLEncoder.encode(date, "UTF-8")+ "&"
                        /*+ URLEncoder.encode("time", "UTF-8") + "=" + URLEncoder.encode("12:12:12", "UTF-8");+ "&"*/
                        + URLEncoder.encode("section", "UTF-8") + "=" + URLEncoder.encode(section_id, "UTF-8")+ "&"
                        + URLEncoder.encode("ccid", "UTF-8") + "=" + URLEncoder.encode(regId, "UTF-8")+ "&"
                        + URLEncoder.encode("attendance", "UTF-8") + "=" + URLEncoder.encode(attendance, "UTF-8")+ "&"
                        + URLEncoder.encode("upload", "UTF-8") + "=" + URLEncoder.encode(upload, "UTF-8");

                bufferedwriter.write(post_data);
                bufferedwriter.flush();
                bufferedwriter.close();

                InputStream inputstream= httpurlconnection.getInputStream();
                BufferedReader bufferedreader= new BufferedReader(new InputStreamReader(inputstream,"iso-8859-1"));
                String result="";
                String line="";
                while((line = bufferedreader.readLine())!=null){
                    result+=line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();

                return result;

            }catch(MalformedURLException e){
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }


            return "";

        }


        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            Toast.makeText(context, ""+time0, Toast.LENGTH_SHORT).show();
                pd = new ProgressDialog(UploadAttendance.this);
                pd.setTitle("Uploading.");
                pd.setMessage("Please wait...\nUploading.");
                pd.setCancelable(false);
                pd.show();}


        @Override
        protected void onPostExecute(String result ){

            String json=result;
            upload="0";
                pd.dismiss();
           // Toast.makeText(context, ""+result, Toast.LENGTH_SHORT).show();
            if(result.equalsIgnoreCase("1"))
            {
                Toast.makeText(context, "Uploaded Successfully", Toast.LENGTH_SHORT).show();
                String tobewritten="";
              for(int i=0;i<datarow.length;i++)
              {
                  if(i!=position){
                  if(tobewritten.equalsIgnoreCase(""))
                  {
                      tobewritten=datarow[i];
                  }
                  else {
                    tobewritten=tobewritten+"&&"+datarow[i];

                  }
                  }
              }
                writeItems(tobewritten);
                readItems();
                datarow = offline_temp_att.split("&&");
                arrayList.clear();
                if(!offline_temp_att.equalsIgnoreCase("")){
                for(int i= 0 ; i< datarow.length;i++)
                {
                    String[] cl_details = datarow[i].split("\\+");
                    Att_list_class a = new Att_list_class(cl_details[0], cl_details[1], cl_details[2], cl_details[3], cl_details[10], cl_details[4]);
                    arrayList.add(a);
                }

            }}
            else if(result.equalsIgnoreCase("0")){
                //Toast.makeText(context, "Attendance Already Exist", Toast.LENGTH_SHORT).show();
                AlertDialog.Builder builder = new AlertDialog.Builder(UploadAttendance.this);
                builder.setMessage("Attendance Already Exist. Want to UPDATE ?")
                        .setCancelable(false)
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                upload="1";
                                String myFormat = "yyyy-MM-dd"; //In which you need put here
                                SimpleDateFormat sdf = new SimpleDateFormat(myFormat, Locale.US);
                                Calendar myCalendar = Calendar.getInstance();
                                edit_date= sdf.format(myCalendar.getTime());
                               //Toast.makeText(context, ""+upload+edit_date, Toast.LENGTH_SHORT).show();
                                AttendanceUploader attendanceUploader = new AttendanceUploader(UploadAttendance.this);
                                attendanceUploader.execute();
                            }
                        })
                        .setNegativeButton("No", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                dialog.cancel();
                            }
                        });
                AlertDialog alert = builder.create();
                alert.show();


            }
            else if(result.equalsIgnoreCase("10")){
                Toast.makeText(context, "Updated", Toast.LENGTH_SHORT).show();
                String tobewritten="";
                for(int i=0;i<datarow.length;i++)
                {
                    if(i!=position){
                        if(tobewritten.equalsIgnoreCase(""))
                        {
                            tobewritten=datarow[i];
                        }
                        else {
                            tobewritten=tobewritten+"&&"+datarow[i];

                        }}
                }
                writeItems(tobewritten);
                readItems();
                datarow = offline_temp_att.split("&&");
                arrayList.clear();
                if(!offline_temp_att.equalsIgnoreCase("")){
                    for(int i= 0 ; i< datarow.length;i++)
                    {
                        String[] cl_details = datarow[i].split("\\+");
                        Att_list_class a = new Att_list_class(cl_details[0], cl_details[1], cl_details[2], cl_details[3], cl_details[10], cl_details[4]);
                        arrayList.add(a);
                    }
                }
            }
            else{
                Toast.makeText(context, "Error Uploading Attendance.", Toast.LENGTH_SHORT).show();
            }
            adapter.notifyDataSetChanged();

        }

    }

    private void writeItems(String s) {
        File filesDir = getFilesDir();
        File todoFile = new File(filesDir,roll_teacher+"temp_attendance.txt");
        try {
            FileUtils.writeStringToFile(todoFile ,s);   // TODO: add depenencies for fill utils
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }
}
