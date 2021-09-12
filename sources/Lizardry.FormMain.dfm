object FormMain: TFormMain
  Left = 0
  Top = 0
  Caption = 'Lizardry'
  ClientHeight = 487
  ClientWidth = 984
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  WindowState = wsMaximized
  OnCreate = FormCreate
  OnShow = FormShow
  PixelsPerInch = 96
  TextHeight = 13
  inline FrameLogin: TFrameLogin
    Left = 0
    Top = 0
    Width = 984
    Height = 487
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 0
    ExplicitWidth = 984
    ExplicitHeight = 487
    inherited Image1: TImage
      Width = 734
      Height = 487
      ExplicitWidth = 734
      ExplicitHeight = 487
    end
    inherited Panel1: TPanel
      Height = 487
      ExplicitHeight = 487
      inherited Label3: TLabel
        Top = 472
        Width = 248
        ExplicitTop = 472
      end
    end
  end
  inline FrameRegistration: TFrameRegistration
    Left = 0
    Top = 0
    Width = 984
    Height = 487
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 1
    ExplicitWidth = 984
    ExplicitHeight = 487
    inherited Image1: TImage
      Width = 734
      Height = 487
      ExplicitWidth = 734
      ExplicitHeight = 487
    end
    inherited Panel1: TPanel
      Height = 487
      ExplicitHeight = 487
    end
  end
  inline FrameTown: TFrameTown
    Left = 0
    Top = 0
    Width = 984
    Height = 487
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 2
    ExplicitWidth = 984
    ExplicitHeight = 487
    inherited Panel7: TPanel
      Left = 704
      Height = 487
      ExplicitLeft = 704
      ExplicitHeight = 487
    end
    inherited Panel1: TPanel
      Height = 487
      ExplicitLeft = 0
      ExplicitHeight = 487
      inherited LinkPanel6: TPanel
        ExplicitLeft = 0
        ExplicitTop = 125
      end
      inherited LinkPanel7: TPanel
        ExplicitLeft = 0
        ExplicitTop = 150
      end
      inherited LinkPanel8: TPanel
        ExplicitTop = 175
      end
      inherited LinkPanel9: TPanel
        ExplicitLeft = 0
        ExplicitTop = 200
      end
      inherited LinkPanel10: TPanel
        ExplicitLeft = 0
        ExplicitTop = 225
      end
    end
    inherited Panel9: TPanel
      Width = 424
      Height = 487
      ExplicitWidth = 424
      ExplicitHeight = 487
      inherited Panel10: TPanel
        Width = 424
        ExplicitWidth = 424
      end
      inherited FramePanel: TPanel
        Top = 287
        Width = 424
        ExplicitTop = 287
        ExplicitWidth = 424
        inherited FrameBank1: TFrameBank
          Width = 422
          ExplicitWidth = 422
        end
        inherited FrameDefault1: TFrameDefault
          Width = 422
          ExplicitWidth = 422
        end
        inherited FrameTavern1: TFrameTavern
          Width = 422
          ExplicitWidth = 422
        end
        inherited FrameOutlands1: TFrameOutlands
          Width = 422
          ExplicitWidth = 422
        end
      end
      inherited Panel19: TPanel
        Width = 424
        Height = 262
        ExplicitWidth = 424
        ExplicitHeight = 262
        inherited FrameInfo1: TFrameInfo
          Width = 422
          Height = 260
          ExplicitWidth = 422
          ExplicitHeight = 260
          inherited StaticText2: TStaticText
            Top = 126
            Width = 422
            ExplicitTop = 126
            ExplicitWidth = 422
          end
          inherited StaticText1: TStaticText
            Width = 422
            Height = 126
            ExplicitWidth = 422
            ExplicitHeight = 126
          end
        end
        inherited FrameLoot1: TFrameLoot
          Width = 422
          Height = 260
          ExplicitWidth = 422
          ExplicitHeight = 260
        end
        inherited FrameBattle1: TFrameBattle
          Width = 422
          Height = 260
          ExplicitWidth = 422
          ExplicitHeight = 260
          inherited Panel1: TPanel
            Width = 422
            Height = 123
            ExplicitWidth = 422
            ExplicitHeight = 123
            inherited RichEdit1: TRichEdit
              Width = 420
              Height = 121
              ExplicitWidth = 420
              ExplicitHeight = 121
            end
          end
          inherited Panel2: TPanel
            Width = 422
            ExplicitWidth = 422
            inherited Panel3: TPanel
              Left = 84
              ExplicitLeft = 84
            end
          end
        end
      end
    end
  end
end
